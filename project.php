<?php

declare(strict_types=1);

use Graywings\PhpDockerTemplate\Composer\Setting\Author;
use Graywings\PhpDockerTemplate\Composer\Setting\PackageName;
use Graywings\PhpDockerTemplate\Composer\Setting\PackageType;
use Graywings\PhpDockerTemplate\Composer\Setting\Setting;
use Graywings\PhpDockerTemplate\Composer\Setting\SoftwareLicense;

require_once 'vendor/autoload.php';

if (!function_exists('main')) {
    function main(): void
    {
        try {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();
            $author = readAuthor();
            $packageName = readPackageName();
            $license = readLicense();
//            $composerSetting = readComposerSetting();
            buildRepository($packageName);
            buildPackagistRepository($packageName);
            system('composer dump-autoload');
            // unlink(__FILE__);
        } catch (RuntimeException $e) {
            echo $e->getMessage();
            require __FILE__;
            return;
        } catch (LogicException $e) {
            echo $e->getMessage() . "\n";
            echo 'Project init failed...' . "\n";
            echo 'Please execute command:' . "\n";
            echo 'make project' . "\n";
            exit;
        }
    }
}

if (!function_exists('readInput')) {
    function readInput(string $prompt): string
    {
        echo $prompt . "\n";
        $input = fgets(STDIN);
        if ($input === false) {
            throw new LogicException('Can\'t read STDIN.');
        }
        return trim($input);
    }
}

if (!function_exists('readPackageName')) {
    function readPackageName(): PackageName
    {
        $packageName = readInput('Enter package name(user_name/project_name):');
        try {
            return new PackageName($packageName);
        } catch (RuntimeException $e) {
            echo $e->getMessage() . "\n";
            return readPackageName();
        }
    }
}

if (!function_exists('readAuthor')) {
    function readAuthor(): Author
    {
        $userName = readInput('Enter author username:');
        $email = readInput('Enter author email:');
        return new Author($userName, $email);
    }
}

if (!function_exists('readLicense')) {
    function readLicense(): SoftwareLicense
    {
        $license = readInput('Enter software license:');
        return SoftwareLicense::from($license);
    }
}

if (!function_exists('readComposerSetting')) {
    function readComposerSetting(): Setting
    {
        $packageName = readPackageName();
        $description = readInput('Enter package description:');
        $packageTypeString = readInput('Enter package type:');
        try {
            $packageType = PackageType::from($packageTypeString);
        } catch (ValueError) {
            echo 'Not supported this package type: ' . $packageTypeString . "\n";
            echo "\n";
            return readComposerSetting();
        }
        return new Setting($packageName, $description, $packageType);
    }
}

if (!function_exists('buildRepository')) {
    function buildRepository(PackageName $packageName): void
    {
        $token = $_ENV['GITHUB_TOKEN'];
        $organizationOrUser = $_ENV['GITHUB_ORGANIZATION_OR_USER'];
        $repositoryName = $packageName->packageName;
        system('git init -M main');
        system('git add .');
        system('git commit -m "Initial commit"');

        system(<<<EOF
curl -L \
  -X POST \
  -H "Accept: application/vnd.github+json" \
  -H "Authorization: Bearer $token" \
  -H "X-GitHub-Api-Version: 2022-11-28" \
  https://api.github.com/orgs/$organizationOrUser/repos \
  -d '{"name":"$repositoryName"}'
EOF);
        system("git remote add origin git@github.com:$organizationOrUser/$repositoryName");
        system("git push origin main");
    }
}

if (!function_exists('buildPackagistRepository')) {
    function buildPackagistRepository(PackageName $packageName): void
    {
        $user = $_ENV['PACKAGIST_USER'];
        $token = $_ENV['PACKAGIST_TOKEN'];
        $organizationOrUser = $_ENV['ORGANIZATION_OR_USER'];
        $repositoryName = $packageName->packageName;
        system(<<<EOF
curl -X POST \
    'https://packagist.org/api/create-package?username=$user&apiToken=$token' \
    -d '{"repository":{"url":"https://github.com/$organizationOrUser/$repositoryName"}}'
EOF);
    }
}

if (!function_exists('buildComposerJson')) {
    function buildComposerJson(): void
    {
    }
}

main();
