<?php

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonFileProvider
     */
    public function testJsonFiles($file)
    {
        $filePath = __DIR__ . '/../data/' . $file;

        $this->assertFileExists($filePath);

        $data = json_decode(file_get_contents($filePath), true);

        $this->assertEquals(JSON_ERROR_NONE, json_last_error(), 'File "'.$file.'" must be a valid JSON');
        $this->assertGreaterThan(0, count($data));
    }

    /**
     * @depends testJsonFiles
     */
    public function testConferencesJson()
    {
        $data = $this->loadJsonFile('companies.json');

        // Check data integrity.
        $keys = [];
        foreach ($data as $i => $entry) {
            $this->assertArrayHasKey('key', $entry, 'Entry #'.$i);
            $this->assertArrayHasKey('name', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('framework', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('website', $entry, 'Entry '.$entry['key']);
            $this->assertNotContains($entry['key'], $keys, 'Key must be unique within the file.');
            $keys[] = $entry['key'];
        }
    }

    private function loadJsonFile($file)
    {
        $filePath = __DIR__ . '/../data/' . $file;
        $data = json_decode(file_get_contents($filePath), true);
        return $data;
    }

    public function flattenHierarchy($hierarchy)
    {
        $flatArray = [];
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($hierarchy), RecursiveIteratorIterator::SELF_FIRST) as $key => $value) {
            $flatArray[] = $key;
        }
        $flatArray = array_unique($flatArray);
        return $flatArray;
    }

    public function jsonFileProvider()
    {
        return [
            ['companies.json'],
        ];

    }

}
