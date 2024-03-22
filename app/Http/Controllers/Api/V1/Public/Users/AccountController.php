<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Users;

use App\Dto\Models\Users\ProfileDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Exceptions\Utils\Apollopayment\ApollopaymentUnavailableException;
use App\Http\Requests\Api\EmptyRequest;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Kyc\FieldOptionService;
use App\Services\Api\V1\Referrals\CodeService;
use App\Services\Api\V1\Referrals\InviteService;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\ProfileService;
use App\Enums\Users\Account\OrderTypeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V3\Apollopayment\ApollopaymentService;
use Exception;

final class AccountController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService,
        private readonly WalletService $walletService,
        private readonly CodeService $codeService,
        private readonly InviteService $inviteService,
        private readonly ProfileService $profileService,
        private readonly FieldOptionService $fieldOptionService,
        private readonly ApollopaymentClientsService $apollopaymentClientsService,
        private readonly EmailService $emailService,
        private readonly ApollopaymentService $apollopaymentService,
    ) {
    }

    public function me(EmptyRequest $request): JsonResponse
    {
        $account = $this->accountService->get(['uuid' => $request->payload()->getUuid()]);
        $code = $this->codeService->get(['account_uuid' => $account->getUuid()]);

        $usedCode = null;
        if ($invite = $this->inviteService->get(['account_uuid' => $account->getUuid()])) {
            $usedCode = $this->codeService->get(['uuid' => $invite->getCodeUuid()]);
        }

        $profile = $this->profileService->get(['account_uuid' => $request->payload()->getUuid()]) ?? ProfileDto::fromArray([]);

        $isAccountHalfYear = $this->accountService->isAccountHalfYear($account->getUuid());
        $isInvite = $this->inviteService->isInvite($account->getUuid());

        $taxResidence = $this->fieldOptionService->get([
            'value' => $profile->getTaxResidence(),
        ])?->getLabel() ?? $profile->getTaxResidence();

        $file = storage_path('/kyc/countries.json');
        $countries = collect(json_decode(file_get_contents($file), true));

        $state = $profile->getState();
        if ($country = $countries->where('value', $profile->getCountry())->first()) {
            foreach ($country['states'] as $item) {
                if ($item['value'] == $profile->getState()) {
                    $state = $item['label'];
                }
            }
        }

        $country = $this->fieldOptionService->get([
            'value' => $profile->getCountry(),
        ])?->getLabel() ?? $profile->getCountry();

        $order_type = $account->getOrderType() === null ? OrderTypeEnum::InitBTC->value : $account->getOrderType();

        $apolloClient = $this->apollopaymentClientsService->get(['account_uuid' => $request->payload()->getUuid()]);
        $tron_wallet = null;
        if (!$apolloClient) {
            $email = $this->emailService->get(['account_uuid' =>  $request->payload()->getUuid()]);
            try {
                $this->apollopaymentService->createUser(
                    $account->getUuid(),
                    $email->getEmail(),
                    $profile->getFullName(),
                    $apolloClient
                );
            } catch (Exception $e) {
                throw new ApollopaymentUnavailableException($e->getMessage());
            }
        } else {
            $tron_wallet = $apolloClient->getTronAddr();
        }

        return response()->json([
            'data' => [
                'account' => [
                    'uuid' => $account->getUuid(),
                    'number' => $account->getNumber(),
                    'username' => $account->getUsername(),
                    'increased' => $isAccountHalfYear && $isInvite,
                    'tron_wallet' => $tron_wallet,
                    'order_type' => $order_type,
                ],
                'profile' => [
                    'full_name' => $profile->getFullName(),
                    'date_of_birth' => $profile->getDateOfBirth(),
                    'tax_residence' => $taxResidence,
                    'address' => $profile->getAddress(),
                    'city' => $profile->getCity(),
                    'postal_code' => $profile->getPostalCode(),
                    'state' => $state,
                    'country' => $country,
                ],
                'referrals' => [
                    'code' => $code?->getCode(),
                    'used_code' => $usedCode?->getCode(),
                ],
                'withdrawal_addresses' => [
                    TypeEnum::DIVIDENDS->value => $this->walletService->get([
                        'account_uuid' => $account->getUuid(),
                        'type' => TypeEnum::DIVIDENDS->value,
                    ])?->getWithdrawalAddress(),
                    TypeEnum::REFERRAL->value => $this->walletService->get([
                        'account_uuid' => $account->getUuid(),
                        'type' => TypeEnum::REFERRAL->value,
                    ])?->getWithdrawalAddress(),
                ],
            ],
        ]);
    }
}
