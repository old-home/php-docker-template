<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Graywings\PhpDockerTemplate\Composer\Setting\Author;
use Graywings\PhpDockerTemplate\Composer\Setting\PackageName;
use Graywings\PhpDockerTemplate\Composer\Setting\PackageType;
use Graywings\PhpDockerTemplate\Composer\Setting\Setting;
use Graywings\PhpDockerTemplate\Composer\Setting\SoftwareLicense;
use Graywings\PhpDockerTemplate\Version\SemVer\StabilityType;

require_once 'vendor/autoload.php';

if (!function_exists('main')) {
    function main(): void
    {
        try {
            if (file_exists(__DIR__ . '/.env')) {
                $dotenv = Dotenv::createImmutable(__DIR__);
                $dotenv->load();
            }
            $packageName = readPackageName();
            $description = readInput('Description []:');
            $author = readAuthor();
            $minimumStability = readMinimumStability();
            $packageType = readPackageType();
            $license = readLicense();
            $keywords = readKeywords();
            buildGitRepository(
                $author,
                $packageName
            );
            buildComposerJson(
                $packageName,
                $description,
                $author,
                $minimumStability,
                $packageType,
                $license,
                $keywords
            );
            buildPackagistRepository($packageName);
            system('composer dump-autoload');
//            unlink(__FILE__);
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
        $packageName = readInput('Package name (<vendor>/<name>) [] : ');
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
        $userName = readInput('Author name:');
        $email = readInput('Author e-mail address:');
        return new Author($userName, $email);
    }
}

if (!function_exists('readMinimumStability')) {
    function readMinimumStability(): StabilityType
    {
        $minimumStability = readInput('Minimum Stability []:');
        try {
            return StabilityType::from($minimumStability);
        } catch (ValueError) {
            echo 'Not supported this stability: ' . $minimumStability . "\n";
            echo "\n";
            return readMinimumStability();
        }
    }
}

if (!function_exists('readLicense')) {
    function readLicense(): SoftwareLicense
    {
        $license = readInput('License []:');
        return SoftwareLicense::from($license);
    }
}

if (!function_exists('readKeywords')) {
    function readKeywords(): array
    {
        $keywords = [];
        foreach (explode(',', readInput('Keywords (comma separated keywords) []:')) as $keyword) {
            $keywords[] = $keyword;
        }
        return $keywords;
    }
}

if (!function_exists('readPackageType')) {
    function readPackageType(): PackageType
    {
        $packageTypeString = readInput('Package type (e.g. library, project, metapackage, composer-plugin) []:');
        try {
            return PackageType::from($packageTypeString);
        } catch (ValueError) {
            echo 'Not supported this package type: ' . $packageTypeString . "\n";
            echo "\n";
            return readPackageType();
        }
    }
}

if (!function_exists('buildGitRepository')) {
    function buildGitRepository(Author $author, PackageName $packageName): void
    {
        $token = $_ENV['GITHUB_TOKEN'];
        $organizationOrUser = $_ENV['GITHUB_ORGANIZATION_OR_USER'];
        $repositoryName = $packageName->packageName;
        $userName = $author->userName;
        $email = $author->email;
        system("git config --global user.name '$userName'");
        system("git config --global user.email '$email'");
        system('git config --global init.defaultBranch main');
        system('git init');

        system(<<<EOF
curl -L \
  -X POST \
  -H "Accept: application/vnd.github+json" \
  -H "Authorization: Bearer $token" \
  -H "X-GitHub-Api-Version: 2022-11-28" \
  https://api.github.com/orgs/$organizationOrUser/repos \
  -d '{"name":"$repositoryName"}'
EOF
        );
        system("git remote add origin git@github.com:$organizationOrUser/$repositoryName");
    }
}

if (!function_exists('commitAndPush')) {
    function commitAndPush(): void
    {
        system('git add .');
        system('git commit -m "Initial commit"');
        system("git push origin main");
    }
}

if (!function_exists('buildPackagistRepository')) {
    function buildPackagistRepository(PackageName $packageName): void
    {
        $user = $_ENV['PACKAGIST_USER'];
        $token = $_ENV['PACKAGIST_TOKEN'];
        $organizationOrUser = $_ENV['GITHUB_ORGANIZATION_OR_USER'];
        $repositoryName = $packageName->packageName;
        system(<<<EOF
curl -X POST \
    'https://packagist.org/api/create-package?username=$user&apiToken=$token' \
    -d '{"repository":{"url":"https://github.com/$organizationOrUser/$repositoryName"}}'
EOF
        );
    }
}

if (!function_exists('buildComposerJson')) {
    function buildComposerJson(
        PackageName     $packageName,
        string          $description,
        Author          $author,
        StabilityType   $minimumStability,
        PackageType     $packageType,
        SoftwareLicense $license,
        array           $keywords
    ): void
    {
        $setting = new Setting(
            $packageName,
            $description,
            $packageType,
            $license,
            $keywords,
            '',
            '',
            '',
            [$author],
            [],
            [],
            [],
            [],
            $minimumStability
        );
        file_put_contents(
            'composer.json',
            json_encode(
                $setting->jsonSerialize(),
                JSON_UNESCAPED_SLASHES |
                JSON_UNESCAPED_SLASHES |
                JSON_UNESCAPED_LINE_TERMINATORS |
                JSON_PRETTY_PRINT
            )
        );
    }
}

main();
