<?php

declare(strict_types=1);

return [
    // Auth
    [
        'interface' => \App\Repositories\Auth\Code\CodeRepositoryInterface::class,
        'implementation' => \App\Repositories\Auth\Code\PgSqlCodeRepository::class,
    ],
    [
        'interface' => \App\Repositories\Auth\RefreshToken\RefreshTokenRepositoryInterface::class,
        'implementation' => \App\Repositories\Auth\RefreshToken\PgSqlRefreshTokenRepository::class,
    ],

    // Users
    [
        'interface' => \App\Repositories\Users\Account\AccountRepositoryInterface::class,
        'implementation' => \App\Repositories\Users\Account\PgSqlAccountRepository::class,
    ],
    [
        'interface' => \App\Repositories\Users\Email\EmailRepositoryInterface::class,
        'implementation' => \App\Repositories\Users\Email\PgSqlEmailRepository::class,
    ],
    [
        'interface' => \App\Repositories\Users\Profile\ProfileRepositoryInterface::class,
        'implementation' => \App\Repositories\Users\Profile\PgSqlProfileRepository::class,
    ],
    [
        'interface' => \App\Repositories\Users\Wallet\WalletRepositoryInterface::class,
        'implementation' => \App\Repositories\Users\Wallet\PgSqlWalletRepository::class,
    ],
    [
        'interface' => \App\Repositories\Users\AppleAccount\AppleAccountRepositoryInterface::class,
        'implementation' => \App\Repositories\Users\AppleAccount\PgSqlAppleAccountRepository::class,
    ],
    [
        'interface' => \App\Repositories\Users\Telegram\TelegramRepositoryInterface::class,
        'implementation' => \App\Repositories\Users\Telegram\PgSqlTelegramRepository::class,
    ],

    // Fund
    [
        'interface' => \App\Repositories\Fund\Shareholder\ShareholderRepositoryInterface::class,
        'implementation' => \App\Repositories\Fund\Shareholder\PgSqlShareholderRepository::class,
    ],

    // Billing
    [
        'interface' => \App\Repositories\Billing\Wallet\WalletRepositoryInterface::class,
        'implementation' => \App\Repositories\Billing\Wallet\PgSqlWalletRepository::class,
    ],
    [
        'interface' => \App\Repositories\Billing\Payment\PaymentRepositoryInterface::class,
        'implementation' => \App\Repositories\Billing\Payment\PgSqlPaymentRepository::class,
    ],
    [
        'interface' => \App\Repositories\Billing\Token\TokenRepositoryInterface::class,
        'implementation' => \App\Repositories\Billing\Token\PgSqlTokenRepository::class,
    ],
    [
        'interface' => \App\Repositories\Billing\Replenishment\ReplenishmentRepositoryInterface::class,
        'implementation' => \App\Repositories\Billing\Replenishment\PgSqlReplenishmentRepository::class,
    ],
    [
        'interface' => \App\Repositories\Billing\Withdrawal\WithdrawalRepositoryInterface::class,
        'implementation' => \App\Repositories\Billing\Withdrawal\PgSqlWithdrawalRepository::class,
    ],
    [
        'interface' => \App\Repositories\Billing\CreditCardRequest\CreditCardRequestRepositoryInterface::class,
        'implementation' => \App\Repositories\Billing\CreditCardRequest\PgSqlCreditCardRequestRepository::class,
    ],

    // News
    [
        'interface' => \App\Repositories\News\Integration\IntegrationRepositoryInterface::class,
        'implementation' => \App\Repositories\News\Integration\PgSqlIntegrationRepository::class,
    ],
    [
        'interface' => \App\Repositories\News\Section\SectionRepositoryInterface::class,
        'implementation' => \App\Repositories\News\Section\PgSqlSectionRepository::class,
    ],
    [
        'interface' => \App\Repositories\News\Tag\TagRepositoryInterface::class,
        'implementation' => \App\Repositories\News\Tag\PgSqlTagRepository::class,
    ],
    [
        'interface' => \App\Repositories\News\Article\ArticleRepositoryInterface::class,
        'implementation' => \App\Repositories\News\Article\PgSqlArticleRepository::class,
    ],
    [
        'interface' => \App\Repositories\News\ArticleTag\ArticleTagRepositoryInterface::class,
        'implementation' => \App\Repositories\News\ArticleTag\PgSqlArticleTagRepository::class,
    ],
    [
        'interface' => \App\Repositories\News\ArticleFile\ArticleFileRepositoryInterface::class,
        'implementation' => \App\Repositories\News\ArticleFile\PgSqlArticleFileRepository::class,
    ],

    // Statistics
    [
        'interface' => \App\Repositories\Statistic\DailyWallet\DailyWalletRepositoryInterface::class,
        'implementation' => \App\Repositories\Statistic\DailyWallet\PgSqlDailyWalletRepository::class,
    ],
    [
        'interface' => \App\Repositories\Statistic\DailyAum\DailyAumRepositoryInterface::class,
        'implementation' => \App\Repositories\Statistic\DailyAum\PgSqlDailyAumRepository::class,
    ],
    [
        'interface' => \App\Repositories\Statistic\Report\ReportRepositoryInterface::class,
        'implementation' => \App\Repositories\Statistic\Report\PgSqlReportRepository::class,
    ],


    // Kyc
    [
        'interface' => \App\Repositories\Kyc\Form\FormRepositoryInterface::class,
        'implementation' => \App\Repositories\Kyc\Form\PgSqlFormRepository::class,
    ],
    [
        'interface' => \App\Repositories\Kyc\Screen\ScreenRepositoryInterface::class,
        'implementation' => \App\Repositories\Kyc\Screen\PgSqlScreenRepository::class,
    ],
    [
        'interface' => \App\Repositories\Kyc\Field\FieldRepositoryInterface::class,
        'implementation' => \App\Repositories\Kyc\Field\PgSqlFieldRepository::class,
    ],
    [
        'interface' => \App\Repositories\Kyc\FieldOption\FieldOptionRepositoryInterface::class,
        'implementation' => \App\Repositories\Kyc\FieldOption\PgSqlFieldOptionRepository::class,
    ],
    [
        'interface' => \App\Repositories\Kyc\Session\SessionRepositoryInterface::class,
        'implementation' => \App\Repositories\Kyc\Session\PgSqlSessionRepository::class,
    ],
    [
        'interface' => \App\Repositories\Kyc\SessionResult\SessionResultRepositoryInterface::class,
        'implementation' => \App\Repositories\Kyc\SessionResult\PgSqlSessionResultRepository::class,
    ],
    [
        'interface' => \App\Repositories\Kyc\SessionFile\SessionFileRepositoryInterface::class,
        'implementation' => \App\Repositories\Kyc\SessionFile\PgSqlSessionFileRepository::class,
    ],

    // Storage
    [
        'interface' => \App\Repositories\Storage\File\FileRepositoryInterface::class,
        'implementation' => \App\Repositories\Storage\File\PgSqlFileRepository::class,
    ],

    // Settings
    [
        'interface' => \App\Repositories\Settings\Global\GlobalRepositoryInterface::class,
        'implementation' => \App\Repositories\Settings\Global\PgSqlGlobalRepository::class,
    ],

    // Referrals
    [
        'interface' => \App\Repositories\Referrals\Code\CodeRepositoryInterface::class,
        'implementation' => \App\Repositories\Referrals\Code\PgSqlCodeRepository::class,
    ],
    [
        'interface' => \App\Repositories\Referrals\Invite\InviteRepositoryInterface::class,
        'implementation' => \App\Repositories\Referrals\Invite\PgSqlInviteRepository::class,
    ],

    // Pages
    [
        'interface' => \App\Repositories\Pages\Page\PageRepositoryInterface::class,
        'implementation' => \App\Repositories\Pages\Page\PgSqlPageRepository::class,
    ],
    [
        'interface' => \App\Repositories\Pages\Section\SectionRepositoryInterface::class,
        'implementation' => \App\Repositories\Pages\Section\PgSqlSectionRepository::class,
    ],
    [
        'interface' => \App\Repositories\Pages\SectionFile\SectionFileRepositoryInterface::class,
        'implementation' => \App\Repositories\Pages\SectionFile\PgSqlSectionFileRepository::class,
    ],
    [
        'interface' => \App\Repositories\Pages\SectionTemplate\SectionTemplateRepositoryInterface::class,
        'implementation' => \App\Repositories\Pages\SectionTemplate\PgSqlSectionTemplateRepository::class,
    ],
    [
        'interface' => \App\Repositories\Pages\SectionTemplateFile\SectionTemplateFileRepositoryInterface::class,
        'implementation' => \App\Repositories\Pages\SectionTemplateFile\PgSqlSectionTemplateFileRepository::class,
    ],
    [
        'interface' => \App\Repositories\Pages\Language\LanguageRepositoryInterface::class,
        'implementation' => \App\Repositories\Pages\Language\PgSqlLanguageRepository::class,
    ],

    // Pap
    [
        'interface' => \App\Repositories\Pap\Tracking\TrackingRepositoryInterface::class,
        'implementation' => \App\Repositories\Pap\Tracking\PgSqlTrackingRepository::class,
    ],

    //Apollopayments
    [
        'interface' => \App\Repositories\Apollopayment\Clients\ClientsRepositoryInterface::class,
        'implementation' => \App\Repositories\Apollopayment\Clients\PgSqlClientsRepository::class,
    ],
    [
        'interface' => \App\Repositories\Apollopayment\Webhooks\WebhooksRepositoryInterface::class,
        'implementation' => \App\Repositories\Apollopayment\Webhooks\WebhooksRepository::class,
    ],

];
