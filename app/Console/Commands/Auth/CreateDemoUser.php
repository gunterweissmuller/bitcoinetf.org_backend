<?php

declare(strict_types=1);

namespace App\Console\Commands\Auth;

use App\Dto\Models\Apollopayment\ClientsDto;
use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitPipelineDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Enums\Auth\Code\TypeEnum;
use App\Pipelines\V1\Auth\Register\RegisterPipeline;
use App\Services\Api\V1\Auth\CodeService;
use Illuminate\Console\Command;

final class CreateDemoUser extends Command
{
    protected $signature = 'auth:create-demo-user';

    protected $description = 'Create demo user by login and password';

    public function handle(RegisterPipeline $registerPipeline, CodeService $codeService): void
    {
        $this->info("Start Create demo user");

        try {

            $email = strtolower('demouser' . rand() . '@bitcoinetf.org');
            $password = 'DemoUser123#';

            $InitDTO = InitPipelineDto::fromArray([
                'account' => AccountDto::fromArray([
                    'send_mail' => 'N',
                    'allowed_withdrawal' => false,
                ]),
                'profile' => ProfileDto::fromArray([
                    'full_name' => "demo user",
                    'phone_number' => '123456789',
                    'phone_number_code' => '000',
                ]),
                'email' => EmailDto::fromArray(['email' => $email]),
                'ref_code' => \App\Dto\Models\Referrals\CodeDto::fromArray(['code' => null]),
                'apolloClient' => ClientsDto::fromArray([]),
            ]);

            [$userDto, $e] = $registerPipeline->initDemoUser($InitDTO);
            if ($e) {
                throw new \Exception($e);
            }

            $accountUuid = $userDto->getAccount()->getUuid();

            $code = $codeService->create(CodeDto::fromArray([
                'account_uuid' => $accountUuid,
                'status' => StatusEnum::Unused->value,
                'type' => TypeEnum::Registration->value,
            ]));

            $confirmDTO = ConfirmPipelineDto::fromArray([
                'email' => EmailDto::fromArray(['email' => $email]),
                'code' => CodeDto::fromArray([
                    'code' => $code->getCode(),
                ]),
                'account' => AccountDto::fromArray(['password' => $password]),
                'is_fast' => false,
            ]);

            [$userDto, $e] = $registerPipeline->confirmDemoUser($confirmDTO);

            if ($e) {
                throw new \Exception($e);
            }
            $this->info("End Create demo user: Demo User account_uuid is $accountUuid");

        } catch (\Throwable $exception) {
            $this->info("Error Create demo user: " . $exception->getMessage());
        }
    }
}
