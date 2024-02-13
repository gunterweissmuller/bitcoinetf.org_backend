<?php

declare(strict_types=1);

namespace App\Services\Docs\Swagger;

use Symfony\Component\Yaml\Yaml;

final class BundlerService
{
    public const PUBLIC_REALMS = 'public';

    public const PRIVATE_REALMS = 'private';

    public const VERSION_V1 = 'v1';

    private const SECTIONS = [
        'paths',
    ];

    public function build(string $version, string $scope): string
    {
        $scopePath = base_path('docs/swagger').'/'.$version.'/'.$scope;
        $outputFileName = $scopePath.'/openapi-'.$scope.'.yaml';
        $currentPath = $scopePath.'/src/';
        $collector = $currentPath.'_openapi.yaml';

        $data = $this->prepareData($collector, $currentPath);

        $yamlData = $this->convertToYamlFile($data);

        file_put_contents($outputFileName, $yamlData);

        return $outputFileName;
    }

    private function prepareData(string $collector, string $currentPath): array
    {
        $data = $this->getYamlFileContentAsArray($collector);

        foreach (self::SECTIONS as $section) {
            $sectionPath = $data[$section];
            $array[$section] = [];
            $sectionCollector = $currentPath.$sectionPath;

            $components = $this->getYamlFileContentAsArray($sectionCollector);

            $tmpIterator = 1;
            $componentsData = [];

            foreach ($components as $key => $component) {
                $componentPath = $currentPath.$section.$component;

                // костыль для красивых роутов в доке
                $tmpStr = explode('/', $key)[0];
                if ($tmpStr != '') {
                    $key = str_replace($tmpStr, '', $key);

                    for ($i = 0; $i < $tmpIterator; ++$i) {
                        $key = ' '.$key;
                    }

                    $tmpIterator++;
                }

                $componentsData[$key] = $this->getYamlFileContentAsArray($componentPath);
            }

            $data[$section] = $componentsData;
        }

        return $data;
    }

    private function getYamlFileContentAsArray(string $ref): array
    {
        $content = file_get_contents($ref);

        $data = Yaml::parse($content, Yaml::PARSE_DATETIME);

        if (!is_array($data)) {
            $data = [];
        }

        return $data;
    }

    private function convertToYamlFile(array $data): string
    {
        return Yaml::dump(
            $data,
            30,
            2,
            Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE | Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK
        );
    }
}
