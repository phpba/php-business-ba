<?php
namespace PhpBa\PhpBusinessBa\Repository\CSV;

use PhpBa\PhpBusinessBa\Repository\RepositoryInterface;

/**
 * responsible class process the csv data
 *
 * Class RepositoryCSV
 * @package PhpBa\PhpBusinessBa\Repository\CSV
 * @author edyonil <edyonil@gmail.com>
 */
class RepositoryCSV implements RepositoryInterface
{
    /**
     * Key google spreadsheet
     *
     * @var string
     */
    private $key;

    /**
     * RepositoryCSV constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * returns the worksheet data
     *
     * @return array
     */
    public function getData() : array
    {
        $spreadsheetData = [];
        $fileRows = $this->processData();

        foreach ($fileRows as $key => $file) {
            if ($key > 0) {
                $data = str_getcsv($file, ',');
                $spreadsheetData[] =
                    [
                        'key' => $key,
                        'name' => $data[1],
                        'city' => $data[2],
                        'employees' => $data[3],
                        'website' => $data[4],
                        'years_using_php' => $data[5],
                        'frameworks' => (!empty($data[6])) ? explode(',', $data[6]) : [],
                        'tests' => (!empty($data[7])) ? explode(',', $data[7]) : [],
                        'other_technologies' => (!empty($data[8])) ? explode(',', $data[8]) : []
                    ];
            }
        }

        return $spreadsheetData;
    }

    /**
     * returns the worksheet url with the specified id
     *
     * @return string
     */
    protected function getUrl()
    {
        return "https://docs.google.com/spreadsheets/d/{$this->key}/export?&format=csv&id={$this->key}";
    }

    /**
     * It makes the request and processing spreadsheet data
     *
     * @return array
     */
    protected function processData() : array
    {
        $url = $this->getUrl();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $fileRows = explode("\n", curl_exec($ch));
        //Gets bool if an error is found 404
        $is404 = curl_getinfo($ch, CURLINFO_HTTP_CODE) == 404;
        curl_close($ch);

        if ($is404) {
            throw new \RuntimeException("File CSV not found");
        }

        return $fileRows;
    }
}
