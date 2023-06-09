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
  'albertcht/invisible-recaptcha' => 'v1.9.6@d69593858de5ede82cccf72ff17ff651fdba6eff',
  'arrilot/laravel-widgets' => '3.13.1@ae0e44ce625026ae71c6ab9259f89f13af227e37',
  'biscolab/laravel-recaptcha' => '4.4.0@a9f5645aeac0747506cb75ccc3bb70e7fada5a7e',
  'bnbwebexpertise/laravel-attachments' => '1.0.22@d3f4aa024449ad938d564aede64d05e19bfc5ff5',
  'bnbwebexpertise/php-uuid' => '0.0.3@d60bf8054db1d062f2fc79c43af0ff499a49fbfa',
  'bumbummen99/shoppingcart' => '2.10.0@2d11e6ad582bf99b7e4f02459d1339394b2b1fa7',
  'cocur/slugify' => 'v4.0.0@3f1ffc300f164f23abe8b64ffb3f92d35cec8307',
  'composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6',
  'cviebrock/eloquent-sluggable' => '6.0.4@752d29751a8dcc16cfe17ed5796bc91ace854140',
  'cybercog/laravel-love' => '8.3.1@a032e92d7c87334f8b67e6e7eb8f8a9ccea3c572',
  'davejamesmiller/laravel-breadcrumbs' => '5.3.2@99f92a706faefb5e1816caa96e877a0184509e5b',
  'dnoegel/php-xdg-base-dir' => 'v0.1.1@8f8a6e48c5ecb0f991c2fdcf5f154a47d85f9ffd',
  'doctrine/cache' => '1.11.0@a9c1b59eba5a08ca2770a76eddb88922f504e8e0',
  'doctrine/dbal' => '2.13.1@c800380457948e65bbd30ba92cc17cda108bf8c9',
  'doctrine/deprecations' => 'v0.5.3@9504165960a1f83cc1480e2be1dd0a0478561314',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '2.0.3@9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'dragonmantank/cron-expression' => 'v2.3.1@65b2d8ee1f10915efb3b55597da3404f096acba2',
  'egulias/email-validator' => '2.1.25@0dbf5d78455d4d6a41d186da50adc1122ec066f4',
  'facade/ignition-contracts' => '1.0.1@aeab1ce8b68b188a43e81758e750151ad7da796b',
  'filp/whoops' => '2.12.1@c13c0be93cff50f88bbd70827d993026821914dd',
  'graham-campbell/manager' => 'v4.6.0@e18c29f98adb770bd890b6d66b27ba4730272599',
  'guzzlehttp/guzzle' => '7.3.0@7008573787b430c1c1f650e3722d9bba59967628',
  'guzzlehttp/promises' => '1.4.1@8e7d04f1f6450fef59366c399cfad4b9383aa30d',
  'guzzlehttp/psr7' => '1.8.2@dc960a912984efb74d0a90222870c72c87f10c91',
  'haruncpi/laravel-id-generator' => 'v1.0.8@c8b1814df3615b22217ec7669d863fd18e3226cb',
  'hashids/hashids' => '4.1.0@8cab111f78e0bd9c76953b082919fc9e251761be',
  'intervention/image' => '2.5.1@abbf18d5ab8367f96b3205ca3c89fb2fa598c69e',
  'jakub-onderka/php-console-color' => 'v0.2@d5deaecff52a0d61ccb613bb3804088da0307191',
  'jakub-onderka/php-console-highlighter' => 'v0.4@9f7a229a69d52506914b4bc61bfdb199d90c5547',
  'james-heinrich/getid3' => 'v1.9.20@3c15e353b9bb1252201c73394bb8390b573a751d',
  'kkszymanowski/traitor' => '0.2.5@9770fc7de72ff585601dc9c42b31715d9fc40a24',
  'laminas/laminas-diactoros' => '2.4.1@36ef09b73e884135d2059cc498c938e90821bb57',
  'laminas/laminas-zendframework-bridge' => '1.1.1@6ede70583e101030bcace4dcddd648f760ddf642',
  'laravel/framework' => 'v6.20.26@0117d797dc1ab64b1f88d4f6b966380ea7def091',
  'laravel/nexmo-notification-channel' => 'v2.5.1@178c9f0eb3a18d4b5682471bffca104a15d817a7',
  'laravel/slack-notification-channel' => 'v2.3.1@f428e76b8d0a0a2ff413ab225eeb829b9a8ffc20',
  'laravel/socialite' => 'v4.4.1@80951df0d93435b773aa00efe1fad6d5015fac75',
  'laravel/tinker' => 'v1.0.10@ad571aacbac1539c30d480908f9d0c9614eaf1a7',
  'laravelcollective/html' => 'v6.2.1@ae15b9c4bf918ec3a78f092b8555551dd693fde3',
  'lcobucci/jwt' => '3.4.5@511629a54465e89a31d3d7e4cf0935feab8b14c1',
  'league/commonmark' => '1.6.0@19a9673b833cc37770439097b381d86cd125bfe8',
  'league/flysystem' => '1.1.3@9be3b16c877d477357c015cec057548cf9b2a14a',
  'league/glide' => '1.7.0@ae5e26700573cb678919d28e425a8b87bc71c546',
  'league/mime-type-detection' => '1.7.0@3b9dff8aaf7323590c1d2e443db701eb1f9aa0d3',
  'league/oauth1-client' => 'v1.9.0@1e7e6be2dc543bf466236fb171e5b20e1b06aee6',
  'maennchen/zipstream-php' => '1.2.0@6373eefe0b3274d7b702d81f2c99aa977ff97dc2',
  'monolog/monolog' => '1.26.0@2209ddd84e7ef1256b7af205d0717fb62cfc9c33',
  'myclabs/php-enum' => '1.7.7@d178027d1e679832db9f38248fcc7200647dc2b7',
  'nesbot/carbon' => '2.47.0@606262fd8888b75317ba9461825a24fc34001e1e',
  'nexmo/laravel' => '2.4.1@029bdc19fc58cd6ef0aa75c7041d82b9d9dc61bd',
  'nikic/php-parser' => 'v4.10.5@4432ba399e47c66624bc73c8c0f811e5c109576f',
  'opis/closure' => '3.6.2@06e2ebd25f2869e54a306dda991f7db58066f7f6',
  'paragonie/random_compat' => 'v9.99.99@84b4dfb120c6f9b4ff7b3685f9b8f1aa365a0c95',
  'paragonie/sodium_compat' => 'v1.15.4@8a93bfe047c7f699f819459de8ddda144cd636a4',
  'phpoption/phpoption' => '1.7.5@994ecccd8f3283ecf5ac33254543eb0ac946d525',
  'pion/laravel-chunk-upload' => 'v1.4.1@149f911041f94efc6b030ee92691f075e29afb9d',
  'psr/container' => '1.1.1@8622567409010282b7aeebe4bb841fe98b58dcaf',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.4@d49695b909c3b7628b6289db5479a1c204601f11',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.9.12@90da7f37568aee36b116a030c5f99c915267edd4',
  'pusher/pusher-php-server' => 'v4.1.5@251f22602320c1b1aff84798fe74f3f7ee0504a9',
  'rajurayhan/larastreamer' => 'v1.0.0@2ce1da37754d6c638a6bc21fb812278995bb7ca7',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/uuid' => '3.9.3@7e1633a6964b48589b142d60542f9ed31bd37a92',
  'rap2hpoutre/laravel-log-viewer' => 'v1.4.0@3506baaddbe5661fc4482b048db2ec5cfc5f9025',
  'santigarcor/laratrust' => '5.2.9@454a338500ea5ab2807da5ee0a799c9c3d01cc05',
  'shivella/laravel-bitly' => '1.1.10@c7a81df3e87a3ca5b81e19c558ab5d774d637251',
  'spatie/eloquent-sortable' => '3.8.2@18451ecf44b28a14ac0ed8803d0f5195a78a48a2',
  'spatie/image' => '1.10.5@63a963d0200fb26f2564bf7201fc7272d9b22933',
  'spatie/image-optimizer' => '1.4.0@c22202fdd57856ed18a79cfab522653291a6e96a',
  'spatie/laravel-medialibrary' => '7.18.0@6461708267ca8863b351eb70f6d5eb324a3eec0b',
  'spatie/laravel-tags' => '2.7.2@06774e5fdb6dbdb767ef84a1cac0f19fb6737a1f',
  'spatie/laravel-translatable' => '4.6.0@5900d6002a5795712058a04c7ca7c2c44b3e0850',
  'spatie/pdf-to-image' => '1.2.2@9a5cb264a99e87e010c65d4ece03b51f821d55bd',
  'spatie/temporary-directory' => '1.3.0@f517729b3793bca58f847c5fd383ec16f03ffec6',
  'swiftmailer/swiftmailer' => 'v6.2.7@15f7faf8508e04471f666633addacf54c0ab5933',
  'symfony/console' => 'v4.4.22@36bbd079b69b94bcc9c9c9e1e37ca3b1e7971625',
  'symfony/css-selector' => 'v5.2.7@59a684f5ac454f066ecbe6daecce6719aed283fb',
  'symfony/debug' => 'v4.4.22@45b2136377cca5f10af858968d6079a482bca473',
  'symfony/deprecation-contracts' => 'v2.4.0@5f38c8804a9e97d23e0c8d63341088cd8a22d627',
  'symfony/error-handler' => 'v4.4.22@76603a8df8e001436df80758eb03a8baa5324175',
  'symfony/event-dispatcher' => 'v4.4.20@c352647244bd376bf7d31efbd5401f13f50dad0c',
  'symfony/event-dispatcher-contracts' => 'v1.1.9@84e23fdcd2517bf37aecbd16967e83f0caee25a7',
  'symfony/finder' => 'v4.4.20@2543795ab1570df588b9bbd31e1a2bd7037b94f6',
  'symfony/http-client-contracts' => 'v2.4.0@7e82f6084d7cae521a75ef2cb5c9457bbda785f4',
  'symfony/http-foundation' => 'v4.4.22@1a6f87ef99d05b1bf5c865b4ef7992263e1cb081',
  'symfony/http-kernel' => 'v4.4.22@cd2e325fc34a4a5bbec91eecf69dda8ee8c5ea4f',
  'symfony/mime' => 'v5.2.7@7af452bf51c46f18da00feb32e1ad36db9426515',
  'symfony/polyfill-ctype' => 'v1.22.1@c6c942b1ac76c82448322025e084cadc56048b4e',
  'symfony/polyfill-iconv' => 'v1.22.1@06fb361659649bcfd6a208a0f1fcaf4e827ad342',
  'symfony/polyfill-intl-idn' => 'v1.22.1@2d63434d922daf7da8dd863e7907e67ee3031483',
  'symfony/polyfill-intl-normalizer' => 'v1.22.1@43a0283138253ed1d48d352ab6d0bdb3f809f248',
  'symfony/polyfill-mbstring' => 'v1.22.1@5232de97ee3b75b0360528dae24e73db49566ab1',
  'symfony/polyfill-php72' => 'v1.22.1@cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9',
  'symfony/polyfill-php73' => 'v1.22.1@a678b42e92f86eca04b7fa4c0f6f19d097fb69e2',
  'symfony/polyfill-php80' => 'v1.22.1@dc3063ba22c2a1fd2f45ed856374d79114998f91',
  'symfony/process' => 'v4.4.22@f5481b22729d465acb1cea3455fc04ce84b0148b',
  'symfony/routing' => 'v4.4.22@049e7c5c41f98511959668791b4adc0898a821b3',
  'symfony/service-contracts' => 'v2.4.0@f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb',
  'symfony/translation' => 'v4.4.21@eb8f5428cc3b40d6dffe303b195b084f1c5fbd14',
  'symfony/translation-contracts' => 'v2.4.0@95c812666f3e91db75385749fe219c5e494c7f95',
  'symfony/var-dumper' => 'v4.4.22@c194bcedde6295f3ec3e9eba1f5d484ea97c41a7',
  'tijsverkoyen/css-to-inline-styles' => '2.2.3@b43b05cf43c1b6d849478965062b6ef73e223bb5',
  'vinkla/hashids' => '7.0.0@97ddf2d3b9f68c6fb438d378113cb96396b544ef',
  'vlucas/phpdotenv' => 'v3.6.8@5e679f7616db829358341e2d5cccbd18773bdab8',
  'vonage/client' => '2.4.0@29f23e317d658ec1c3e55cf778992353492741d7',
  'vonage/client-core' => '2.9.2@2b734ff7d86d4b6f169df49aed3aefcdac7a40d0',
  'vonage/nexmo-bridge' => '0.1.0@62653b1165f4401580ca8d2b859f59c968de3711',
  'webpatser/laravel-countries' => '1.5.4@000d7aaa67a1eb488275feafe6ab74a6b7544e84',
  'doctrine/instantiator' => '1.4.0@d56bf6102915de5702778fe20f2de3b2fe570b5b',
  'fzaninotto/faker' => 'v1.9.2@848d8125239d7dbf8ab25cb7f054f1a630e68c2e',
  'hamcrest/hamcrest-php' => 'v1.2.2@b37020aa976fa52d3de9aa904aa2522dc518f79c',
  'laravel-shift/blueprint' => 'v1.24.1@759eac3cbee489ced687feac321c9c5d845c634f',
  'laravel-shift/faker-registry' => 'v0.1.0@051c1d50f428b699ee9456072f9c54cb073a006f',
  'martinlindhe/laravel-vue-i18n-generator' => '0.1.46@ddc52890f0204dff64d25e30c3473332904c6138',
  'mockery/mockery' => '0.9.11@be9bf28d8e57d67883cba9fcadfcff8caab667f8',
  'myclabs/deep-copy' => '1.10.2@776f831124e9c62e1a2c601ecc52e776d8bb7220',
  'phar-io/manifest' => '1.0.1@2df402786ab5368a0169091f61a7c1e0eb6852d0',
  'phar-io/version' => '1.0.1@a70c0ced4be299a63d32fa96d9281d03e94041df',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.2.2@069a785b2141f5bcf49f3e353548dc1cce6df556',
  'phpdocumentor/type-resolver' => '1.4.0@6a467b8989322d92aa1c8bf2bebcc6e5c2ba55c0',
  'phpspec/prophecy' => 'v1.10.3@451c3cd1418cf640de218914901e51b064abb093',
  'phpunit/php-code-coverage' => '5.3.2@c89677919c5dd6d3b3852f230a663118762218ac',
  'phpunit/php-file-iterator' => '1.4.5@730b01bc3e867237eaac355e06a36b85dd93a8b4',
  'phpunit/php-text-template' => '1.2.1@31f8b717e51d9a2afca6c9f046f5d69fc27c8686',
  'phpunit/php-timer' => '1.0.9@3dcf38ca72b158baf0bc245e9184d3fdffa9c46f',
  'phpunit/php-token-stream' => '2.0.2@791198a2c6254db10131eecfe8c06670700904db',
  'phpunit/phpunit' => '6.5.14@bac23fe7ff13dbdb461481f706f0e9fe746334b7',
  'phpunit/phpunit-mock-objects' => '5.0.10@cd1cf05c553ecfec36b170070573e540b67d3f1f',
  'sebastian/code-unit-reverse-lookup' => '1.0.2@1de8cd5c010cb153fcd68b8d0f64606f523f7619',
  'sebastian/comparator' => '2.1.3@34369daee48eafb2651bea869b4b15d75ccc35f9',
  'sebastian/diff' => '2.0.1@347c1d8b49c5c3ee30c7040ea6fc446790e6bddd',
  'sebastian/environment' => '3.1.0@cd0871b3975fb7fc44d11314fd1ee20925fce4f5',
  'sebastian/exporter' => '3.1.3@6b853149eab67d4da22291d36f5b0631c0fd856e',
  'sebastian/global-state' => '2.0.0@e8ba02eed7bbbb9e59e43dedd3dddeff4a56b0c4',
  'sebastian/object-enumerator' => '3.0.4@e67f6d32ebd0c749cf9d1dbd9f226c727043cdf2',
  'sebastian/object-reflector' => '1.1.2@9b8772b9cbd456ab45d4a598d2dd1a1bced6363d',
  'sebastian/recursion-context' => '3.0.1@367dcba38d6e1977be014dc4b22f47a484dac7fb',
  'sebastian/resource-operations' => '1.0.0@ce990bb21759f94aeafd30209e8cfcdfa8bc3f52',
  'sebastian/version' => '2.0.1@99732be0ddb3361e16ad77b68ba41efc8e979019',
  'symfony/yaml' => 'v5.2.7@76546cbeddd0a9540b4e4e57eddeec3e9bb444a5',
  'theseer/tokenizer' => '1.2.0@75a63c33a8577608444246075ea0af0d052e452a',
  'webmozart/assert' => '1.10.0@6964c76c7804814a842473e0c8fd15bab0f18e25',
  'laravel/laravel' => 'dev-development@f6fdc0df862590fc40bf17253e8e06f25daa3da3',
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
