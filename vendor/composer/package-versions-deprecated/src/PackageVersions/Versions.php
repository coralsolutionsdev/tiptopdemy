<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'laravel/laravel';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'albertcht/invisible-recaptcha' => 'v1.9.4@dd74d80e8e10d27bced23ac8fad4c8ac0f3c4728',
  'arrilot/laravel-widgets' => '3.13.0@24297e9a7b1988808b782567892170cd421e6715',
  'biscolab/laravel-recaptcha' => '4.4.0@a9f5645aeac0747506cb75ccc3bb70e7fada5a7e',
  'bnbwebexpertise/laravel-attachments' => '1.0.22@d3f4aa024449ad938d564aede64d05e19bfc5ff5',
  'bnbwebexpertise/php-uuid' => '0.0.3@d60bf8054db1d062f2fc79c43af0ff499a49fbfa',
  'bumbummen99/shoppingcart' => '2.10.0@2d11e6ad582bf99b7e4f02459d1339394b2b1fa7',
  'cocur/slugify' => 'v4.0.0@3f1ffc300f164f23abe8b64ffb3f92d35cec8307',
  'composer/package-versions-deprecated' => '1.11.99@c8c9aa8a14cc3d3bec86d0a8c3fa52ea79936855',
  'cviebrock/eloquent-sluggable' => '6.0.3@ebaefa01b810b93d0c33a0465eb6c53c38340388',
  'cybercog/laravel-love' => '8.3.1@a032e92d7c87334f8b67e6e7eb8f8a9ccea3c572',
  'davejamesmiller/laravel-breadcrumbs' => '5.3.2@99f92a706faefb5e1816caa96e877a0184509e5b',
  'dnoegel/php-xdg-base-dir' => 'v0.1.1@8f8a6e48c5ecb0f991c2fdcf5f154a47d85f9ffd',
  'doctrine/cache' => '1.10.2@13e3381b25847283a91948d04640543941309727',
  'doctrine/dbal' => '2.10.4@47433196b6390d14409a33885ee42b6208160643',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '2.0.3@9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'dragonmantank/cron-expression' => 'v2.3.0@72b6fbf76adb3cf5bc0db68559b33d41219aba27',
  'egulias/email-validator' => '2.1.20@f46887bc48db66c7f38f668eb7d6ae54583617ff',
  'facade/ignition-contracts' => '1.0.1@aeab1ce8b68b188a43e81758e750151ad7da796b',
  'filp/whoops' => '2.7.3@5d5fe9bb3d656b514d455645b3addc5f7ba7714d',
  'graham-campbell/manager' => 'v4.6.0@e18c29f98adb770bd890b6d66b27ba4730272599',
  'guzzlehttp/guzzle' => '6.5.5@9d4290de1cfd701f38099ef7e183b64b4b7b0c5e',
  'guzzlehttp/promises' => 'v1.3.1@a59da6cf61d80060647ff4d3eb2c03a2bc694646',
  'guzzlehttp/psr7' => '1.6.1@239400de7a173fe9901b9ac7c06497751f00727a',
  'haruncpi/laravel-id-generator' => 'v1.0.5@5d81b7a8232b434e07a84376ec6c63f43bc055cf',
  'hashids/hashids' => '4.0.0@43bb2407f16a631f0128f47bcb67ff986c63dde2',
  'intervention/image' => '2.5.1@abbf18d5ab8367f96b3205ca3c89fb2fa598c69e',
  'jakub-onderka/php-console-color' => 'v0.2@d5deaecff52a0d61ccb613bb3804088da0307191',
  'jakub-onderka/php-console-highlighter' => 'v0.4@9f7a229a69d52506914b4bc61bfdb199d90c5547',
  'james-heinrich/getid3' => 'v1.9.20@3c15e353b9bb1252201c73394bb8390b573a751d',
  'kkszymanowski/traitor' => '0.2.5@9770fc7de72ff585601dc9c42b31715d9fc40a24',
  'laminas/laminas-diactoros' => '2.4.1@36ef09b73e884135d2059cc498c938e90821bb57',
  'laminas/laminas-zendframework-bridge' => '1.1.1@6ede70583e101030bcace4dcddd648f760ddf642',
  'laravel/framework' => 'v6.18.40@e42450df0896b7130ccdb5290a114424e18887c9',
  'laravel/nexmo-notification-channel' => 'v2.4.0@7ebc8cec1a62d61af7ed5ccc6602beb68965d1a8',
  'laravel/slack-notification-channel' => 'v2.2.0@98e0fe5c8dda645e6af914285af7b742e167462a',
  'laravel/socialite' => 'v4.4.1@80951df0d93435b773aa00efe1fad6d5015fac75',
  'laravel/tinker' => 'v1.0.10@ad571aacbac1539c30d480908f9d0c9614eaf1a7',
  'laravelcollective/html' => 'v6.2.0@3bb99be7502feb2129b375cd026ccb0fa4b66628',
  'lcobucci/jwt' => '3.3.3@c1123697f6a2ec29162b82f170dd4a491f524773',
  'league/commonmark' => '1.5.5@45832dfed6007b984c0d40addfac48d403dc6432',
  'league/flysystem' => '1.1.3@9be3b16c877d477357c015cec057548cf9b2a14a',
  'league/glide' => '1.6.0@8759b8edfe953c8e6aceb45b3647fb7ae5349a0c',
  'league/mime-type-detection' => '1.4.0@fda190b62b962d96a069fcc414d781db66d65b69',
  'league/oauth1-client' => 'v1.8.1@3a68155c3f27a91f4b66a2dc03996cd6f3281c9f',
  'maennchen/zipstream-php' => '1.2.0@6373eefe0b3274d7b702d81f2c99aa977ff97dc2',
  'monolog/monolog' => '1.25.5@1817faadd1846cd08be9a49e905dc68823bc38c0',
  'myclabs/php-enum' => '1.7.6@5f36467c7a87e20fbdc51e524fd8f9d1de80187c',
  'nesbot/carbon' => '2.39.2@326efde1bc09077a26cb77f6e2e32e13f06c27f2',
  'nexmo/client' => '2.0.0@664082abac14f6ab9ceec9abaf2e00aeb7c17333',
  'nexmo/client-core' => '2.4.0@9c6147dc97290373d203a7ca45c1299a68278895',
  'nexmo/laravel' => '2.3.0@f79bd96afa0e8347c2643bd5dfbc3df6a801cc6d',
  'nikic/php-parser' => 'v4.9.1@88e519766fc58bd46b8265561fb79b54e2e00b28',
  'opis/closure' => '3.5.7@4531e53afe2fc660403e76fb7644e95998bff7bf',
  'paragonie/random_compat' => 'v9.99.99@84b4dfb120c6f9b4ff7b3685f9b8f1aa365a0c95',
  'php-http/guzzle6-adapter' => 'v2.0.1@6074a4b1f4d5c21061b70bab3b8ad484282fe31f',
  'php-http/httplug' => '2.2.0@191a0a1b41ed026b717421931f8d3bd2514ffbf9',
  'php-http/promise' => '1.1.0@4c4c1f9b7289a2ec57cde7f1e9762a5789506f88',
  'phpoption/phpoption' => '1.7.5@994ecccd8f3283ecf5ac33254543eb0ac946d525',
  'pion/laravel-chunk-upload' => 'v1.4.0@a97902906e11da3ff26874c7fd0004625c618d44',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.9.12@90da7f37568aee36b116a030c5f99c915267edd4',
  'rajurayhan/larastreamer' => 'v1.0.0@2ce1da37754d6c638a6bc21fb812278995bb7ca7',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/uuid' => '3.9.3@7e1633a6964b48589b142d60542f9ed31bd37a92',
  'rap2hpoutre/laravel-log-viewer' => 'v1.4.0@3506baaddbe5661fc4482b048db2ec5cfc5f9025',
  'santigarcor/laratrust' => '5.2.9@454a338500ea5ab2807da5ee0a799c9c3d01cc05',
  'spatie/eloquent-sortable' => '3.8.2@18451ecf44b28a14ac0ed8803d0f5195a78a48a2',
  'spatie/image' => '1.7.6@74535b5fd67ace75840c00c408666660843e755e',
  'spatie/image-optimizer' => '1.2.1@9c1d470e34b28b715d25edb539dd6c899461527c',
  'spatie/laravel-medialibrary' => '7.18.0@6461708267ca8863b351eb70f6d5eb324a3eec0b',
  'spatie/laravel-tags' => '2.7.2@06774e5fdb6dbdb767ef84a1cac0f19fb6737a1f',
  'spatie/laravel-translatable' => '4.4.1@cc2ce05f2dc9c7eca1ca79613d7dd3026c31e418',
  'spatie/pdf-to-image' => '1.2.2@9a5cb264a99e87e010c65d4ece03b51f821d55bd',
  'spatie/temporary-directory' => '1.2.4@8efe8e61e0ca943d84341f10e51ef3a9606af932',
  'swiftmailer/swiftmailer' => 'v6.2.3@149cfdf118b169f7840bbe3ef0d4bc795d1780c9',
  'symfony/console' => 'v4.4.13@b39fd99b9297b67fb7633b7d8083957a97e1e727',
  'symfony/css-selector' => 'v5.1.5@e544e24472d4c97b2d11ade7caacd446727c6bf9',
  'symfony/debug' => 'v4.4.13@aeb73aca16a8f1fe958230fe44e6cf4c84cbb85e',
  'symfony/error-handler' => 'v4.4.13@2434fb32851f252e4f27691eee0b77c16198db62',
  'symfony/event-dispatcher' => 'v4.4.13@3e8ea5ccddd00556b86d69d42f99f1061a704030',
  'symfony/event-dispatcher-contracts' => 'v1.1.9@84e23fdcd2517bf37aecbd16967e83f0caee25a7',
  'symfony/finder' => 'v4.4.13@2a78590b2c7e3de5c429628457c47541c58db9c7',
  'symfony/http-foundation' => 'v4.4.13@e3e5a62a6631a461954d471e7206e3750dbe8ee1',
  'symfony/http-kernel' => 'v4.4.13@2bb7b90ecdc79813c0bf237b7ff20e79062b5188',
  'symfony/mime' => 'v5.1.5@89a2c9b4cb7b5aa516cf55f5194c384f444c81dc',
  'symfony/polyfill-ctype' => 'v1.18.1@1c302646f6efc070cd46856e600e5e0684d6b454',
  'symfony/polyfill-iconv' => 'v1.18.1@6c2f78eb8f5ab8eaea98f6d414a5915f2e0fce36',
  'symfony/polyfill-intl-idn' => 'v1.18.1@5dcab1bc7146cf8c1beaa4502a3d9be344334251',
  'symfony/polyfill-intl-normalizer' => 'v1.18.1@37078a8dd4a2a1e9ab0231af7c6cb671b2ed5a7e',
  'symfony/polyfill-mbstring' => 'v1.18.1@a6977d63bf9a0ad4c65cd352709e230876f9904a',
  'symfony/polyfill-php70' => 'v1.18.1@0dd93f2c578bdc9c72697eaa5f1dd25644e618d3',
  'symfony/polyfill-php72' => 'v1.18.1@639447d008615574653fb3bc60d1986d7172eaae',
  'symfony/polyfill-php73' => 'v1.18.1@fffa1a52a023e782cdcc221d781fe1ec8f87fcca',
  'symfony/polyfill-php80' => 'v1.18.1@d87d5766cbf48d72388a9f6b85f280c8ad51f981',
  'symfony/process' => 'v4.4.13@65e70bab62f3da7089a8d4591fb23fbacacb3479',
  'symfony/routing' => 'v4.4.13@e3387963565da9bae51d1d3ab8041646cc93bd04',
  'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1',
  'symfony/translation' => 'v4.4.13@700e6e50174b0cdcf0fa232773bec5c314680575',
  'symfony/translation-contracts' => 'v2.2.0@77ce1c3627c9f39643acd9af086631f842c50c4d',
  'symfony/var-dumper' => 'v4.4.13@1bef32329f3166486ab7cb88599cae4875632b99',
  'tijsverkoyen/css-to-inline-styles' => '2.2.3@b43b05cf43c1b6d849478965062b6ef73e223bb5',
  'vinkla/hashids' => '7.0.0@97ddf2d3b9f68c6fb438d378113cb96396b544ef',
  'vlucas/phpdotenv' => 'v3.6.7@2065beda6cbe75e2603686907b2e45f6f3a5ad82',
  'vonage/nexmo-bridge' => '0.1.0@62653b1165f4401580ca8d2b859f59c968de3711',
  'webpatser/laravel-countries' => '1.5.4@000d7aaa67a1eb488275feafe6ab74a6b7544e84',
  'doctrine/instantiator' => '1.3.1@f350df0268e904597e3bd9c4685c53e0e333feea',
  'fzaninotto/faker' => 'v1.9.1@fc10d778e4b84d5bd315dad194661e091d307c6f',
  'hamcrest/hamcrest-php' => 'v1.2.2@b37020aa976fa52d3de9aa904aa2522dc518f79c',
  'laravel-shift/blueprint' => 'v1.18.0@ef82b5b463dddc18a3ea11277b942dba8053f5b8',
  'laravel-shift/faker-registry' => 'v0.1.0@051c1d50f428b699ee9456072f9c54cb073a006f',
  'martinlindhe/laravel-vue-i18n-generator' => '0.1.46@ddc52890f0204dff64d25e30c3473332904c6138',
  'mockery/mockery' => '0.9.11@be9bf28d8e57d67883cba9fcadfcff8caab667f8',
  'myclabs/deep-copy' => '1.10.1@969b211f9a51aa1f6c01d1d2aef56d3bd91598e5',
  'phar-io/manifest' => '1.0.1@2df402786ab5368a0169091f61a7c1e0eb6852d0',
  'phar-io/version' => '1.0.1@a70c0ced4be299a63d32fa96d9281d03e94041df',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.2.1@d870572532cd70bc3fab58f2e23ad423c8404c44',
  'phpdocumentor/type-resolver' => '1.3.0@e878a14a65245fbe78f8080eba03b47c3b705651',
  'phpspec/prophecy' => 'v1.10.3@451c3cd1418cf640de218914901e51b064abb093',
  'phpunit/php-code-coverage' => '5.3.2@c89677919c5dd6d3b3852f230a663118762218ac',
  'phpunit/php-file-iterator' => '1.4.5@730b01bc3e867237eaac355e06a36b85dd93a8b4',
  'phpunit/php-text-template' => '1.2.1@31f8b717e51d9a2afca6c9f046f5d69fc27c8686',
  'phpunit/php-timer' => '1.0.9@3dcf38ca72b158baf0bc245e9184d3fdffa9c46f',
  'phpunit/php-token-stream' => '2.0.2@791198a2c6254db10131eecfe8c06670700904db',
  'phpunit/phpunit' => '6.5.14@bac23fe7ff13dbdb461481f706f0e9fe746334b7',
  'phpunit/phpunit-mock-objects' => '5.0.10@cd1cf05c553ecfec36b170070573e540b67d3f1f',
  'sebastian/code-unit-reverse-lookup' => '1.0.1@4419fcdb5eabb9caa61a27c7a1db532a6b55dd18',
  'sebastian/comparator' => '2.1.3@34369daee48eafb2651bea869b4b15d75ccc35f9',
  'sebastian/diff' => '2.0.1@347c1d8b49c5c3ee30c7040ea6fc446790e6bddd',
  'sebastian/environment' => '3.1.0@cd0871b3975fb7fc44d11314fd1ee20925fce4f5',
  'sebastian/exporter' => '3.1.2@68609e1261d215ea5b21b7987539cbfbe156ec3e',
  'sebastian/global-state' => '2.0.0@e8ba02eed7bbbb9e59e43dedd3dddeff4a56b0c4',
  'sebastian/object-enumerator' => '3.0.3@7cfd9e65d11ffb5af41198476395774d4c8a84c5',
  'sebastian/object-reflector' => '1.1.1@773f97c67f28de00d397be301821b06708fca0be',
  'sebastian/recursion-context' => '3.0.0@5b0cd723502bac3b006cbf3dbf7a1e3fcefe4fa8',
  'sebastian/resource-operations' => '1.0.0@ce990bb21759f94aeafd30209e8cfcdfa8bc3f52',
  'sebastian/version' => '2.0.1@99732be0ddb3361e16ad77b68ba41efc8e979019',
  'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665',
  'symfony/yaml' => 'v5.1.5@a44bd3a91bfbf8db12367fa6ffac9c3eb1a8804a',
  'theseer/tokenizer' => '1.2.0@75a63c33a8577608444246075ea0af0d052e452a',
  'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389',
  'laravel/laravel' => 'dev-development@9cb11e4b0fb110748759319b0455990a68df5087',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
