<?php namespace PhpBa\PhpBusinessBa\Repository;


use PhpBa\PhpBusinessBa\Repository\CSV\RepositoryCSV;

class RepositoryCSVTest extends \PHPUnit_Framework_TestCase
{

    public function builderRepositoryCsv()
    {
        $chaveDaPlanilha = '19ri9qD--XVlTZREolIQ5IA9lJODNeqU2elG9gLN06p0';

        $repository = new RepositoryCSV($chaveDaPlanilha);

        return $repository->getData();
    }

    public function testVerificaSeClassRepositorioInstanciaUmaInterfaceValida()
    {

        $chaveDaPlanilha = '19ri9qD--XVlTZREolIQ5IA9lJODNeqU2elG9gLN06p0';

        $repository = new CSV\RepositoryCSV($chaveDaPlanilha);

        $nameClass = get_class($repository);

        $this->assertInstanceOf('PhpBa\PhpBusinessBa\Repository\RepositoryInterface', $repository, "A classe {$nameClass} não é uma instancia de RepositoryInterface");

    }

    public function testDeveVerificarSeContemItensNaArray()
    {

        $arrayData = $this->builderRepositoryCsv();

        $this->assertTrue(is_array($arrayData));

    }

    public function testDeveVerificarConsistenciaDasColunasNaArray()
    {

        $arrayData = $this->builderRepositoryCsv();

        $keys = [];

        foreach($arrayData as $entry) {

            $this->assertArrayHasKey('key', $entry, 'Coluna key não encontrada');
            $this->assertArrayHasKey('name', $entry, 'Coluna name não encontrada');
            $this->assertArrayHasKey('city', $entry, 'Coluna city não encontrada');
            $this->assertArrayHasKey('employees', $entry, 'Coluna employees não encontrada');
            $this->assertArrayHasKey('website', $entry, 'Coluna website não encontrada');
            $this->assertArrayHasKey('years_using_php', $entry, 'Coluna years_using_php não encontrada');
            $this->assertArrayHasKey('framework', $entry, 'Coluna framework não encontrada');
            $this->assertArrayHasKey('use_tests', $entry, 'Coluna use_tests não encontrada');
            $this->assertNotContains($entry['key'], $keys, 'A key precisa ser unica da lista.');
            $keys[] = $entry['key'];
        }
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testDeveRetornarExceptionCasoNaoEncontrePlanilhaOnline()
    {

        $repository = new RepositoryCSV('testedechave');

        $repository->getData();
    }

}

