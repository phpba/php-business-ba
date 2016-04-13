<?php namespace PhpBa\PhpBusinessBa\Repository\CSV;

use PhpBa\PhpBusinessBa\Repository\RepositoryInterface;

class RepositoryCSV implements RepositoryInterface
{

    private $chave;


    public function __construct(string $chave)
    {

        $this->chave = $chave;

    }

    public function getData() : array
    {

        ini_set('default_socket_timeout', 15);

        $spreadsheet_data = [];

        $fileRows = $this->tratarData();

        foreach ($fileRows as $key => $file) {

            if ($key > 0) {

                $data = str_getcsv($file, ',');

                $spreadsheet_data[] =
                    [
                        'key' => $key,
                        'name' => $data[1],
                        'city' => $data[2],
                        'employees' => $data[3],
                        'website' => $data[4],
                        'years_using_php' => $data[5],
                        'framework' => $data[6],
                        'use_tests' => $data[7]
                    ];
            }
        }


        return $spreadsheet_data;
    }

    protected function getUrl()
    {
        return "https://docs.google.com/spreadsheets/d/{$this->chave}/export?&format=csv&id={$this->chave}";
    }

    protected function tratarData() : array
    {

        $url = $this->getUrl();

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $fileRows = explode("\n", curl_exec($ch));

        $is404 = curl_getinfo($ch, CURLINFO_HTTP_CODE) == 404;

        curl_close($ch);

        if ($is404) {

            throw new \RuntimeException("Arquivo CSV não encontrado");

        }

        return $fileRows;
    }
}
