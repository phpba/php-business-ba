<?php

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonFileProvider
     */
    public function testJsonFiles($file)
    {
        $content = $this->readJsonFile($file);

        $this->assertEquals(JSON_ERROR_NONE, json_last_error(), 'File "' . $file . '" must be a valid JSON');
        $this->assertGreaterThan(0, count($content));
    }

    /**
     * @depends testJsonFiles
     */
    public function testConferencesJson()
    {
        // Check data integrity.
        $keys = [];

        foreach ($this->readJsonFile('companies.json') as $key => $entry) {
            $this->assertArrayHasKey('key', $entry, 'Entry #'.$key);
            $this->assertArrayHasKey('name', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('location', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('city', $entry['location'], 'Entry '.$entry['key']);
            $this->assertArrayHasKey('state', $entry['location'], 'Entry '.$entry['key']);
            $this->assertArrayHasKey('acronym', $entry['location'], 'Entry '.$entry['key']);
            $this->assertArrayHasKey('employees', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('website', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('frameworks', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('tests', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('other_technologies', $entry, 'Entry '.$entry['key']);
            $this->assertNotContains($entry['key'], $keys, 'Key must be unique within the file.');

            $keys[] = $entry['key'];
        }
    }

    private function readJsonFile($file)
    {
        $content = file_get_contents(__DIR__ . '/../data/' . $file);

        return json_decode($content, true);
    }

    public function jsonFileProvider()
    {
        return [
            ['companies.json'],
        ];
    }
}
