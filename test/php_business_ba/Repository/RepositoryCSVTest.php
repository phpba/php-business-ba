<?php
namespace PhpBa\PhpBusinessBa\Repository;

use PhpBa\PhpBusinessBa\Repository\CSV\RepositoryCSV;

/**
 * Class RepositoryCSVTest
 * @package PhpBa\PhpBusinessBa\Repository
 * @author edyonil <edyonil@gmail.com>
 */
class RepositoryCSVTest extends \PHPUnit_Framework_TestCase
{
    protected function builderRepositoryCsv()
    {
        $key = '19ri9qD--XVlTZREolIQ5IA9lJODNeqU2elG9gLN06p0';
        $repository = new RepositoryCSV($key);
        return $repository->getData();
    }

    public function testVerificaSeClassRepositorioInstanciaUmaInterfaceValida()
    {
        $key = '19ri9qD--XVlTZREolIQ5IA9lJODNeqU2elG9gLN06p0';
        $repository = new CSV\RepositoryCSV($key);
        $className = get_class($repository);
        $this->assertInstanceOf('PhpBa\PhpBusinessBa\Repository\RepositoryInterface', $repository,
            "A classe {$className} não é uma instância de RepositoryInterface");
    }

    public function testDeveVerificarSeContemItensNaArray()
    {
        $arrayData = $this->builderRepositoryCsv();
        $this->assertTrue(is_array($arrayData), 'Os dados do repositório não é uma array');
    }

    public function testDeveVerificarConsistenciaDasColunasNaArray()
    {
        $arrayData = $this->builderRepositoryCsv();
        $keys = [];

        foreach ($arrayData as $entry) {
            $this->assertArrayHasKey('key', $entry, 'Coluna key não encontrada');
            $this->assertArrayHasKey('name', $entry, 'Coluna name não encontrada');
            $this->assertArrayHasKey('city', $entry, 'Coluna city não encontrada');
            $this->assertArrayHasKey('employees', $entry, 'Coluna employees não encontrada');
            $this->assertArrayHasKey('website', $entry, 'Coluna website não encontrada');
            $this->assertArrayHasKey('years_using_php', $entry, 'Coluna years_using_php não encontrada');
            $this->assertArrayHasKey('frameworks', $entry, 'Coluna frameworks não encontrada');
            $this->assertArrayHasKey('tests', $entry, 'Coluna tests não encontrada');
            $this->assertArrayHasKey('other_technologies', $entry, 'Coluna other_technologies não encontrada');
            $this->assertNotContains($entry['key'], $keys, 'A key precisa ser unica na lista.');
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

    public function testDeveRetonarErroQuandoFramewoksNaoForArray()
    {
        $arrayData = $this->builderRepositoryCsv();

        foreach ($arrayData as $entry) {

            $this->assertArrayHasKey('frameworks', $entry, 'Coluna framework não encontrada');

            //Testar consistência das novas colunas
            $typeVarFrameworks = gettype($entry['frameworks']);
            $this->assertTrue(is_array($entry['frameworks']), "A coluna frameworks não é um array. Uma {$typeVarFrameworks} foi passado.");
        }
    }

    public function testDeveRetonarErroQuandoTestsNaoForArray()
    {
        $arrayData = $this->builderRepositoryCsv();

        foreach ($arrayData as $entry) {

            $this->assertArrayHasKey('tests', $entry, 'Coluna use_tests não encontrada');

            //Testar consistência das novas colunas
            $typeVarTests = gettype($entry['tests']);
            $this->assertTrue(is_array($entry['tests']), "A coluna tests não é um array. Uma {$typeVarTests} foi passado.");
        }
    }
    public function testDeveRetonarErroQuandoOtherTechnologiesNaoForArray()
    {
        $arrayData = $this->builderRepositoryCsv();

        foreach ($arrayData as $entry) {

            $this->assertArrayHasKey('other_technologies', $entry, 'Coluna other_technologies não encontrada');

            //Testar consistência das novas colunas
            $typeVarOtherTechnologies = gettype($entry['other_technologies']);
            $this->assertTrue(is_array($entry['other_technologies']), "A coluna other_technologies não é um array. Uma {$typeVarOtherTechnologies} foi passado.");
        }
    }

}

