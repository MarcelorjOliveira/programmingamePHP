<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BasicExerciseRepository")
 */
class BasicExercise {

  public function __set($name, $value) {
      $method = 'set' . $name;
      if (('mapper' == $name) || !method_exists($this, $method)) {
          throw new Exception('Propriedade do exercise no set inválido');
      }

      $this->$method($value);
  }

  public function __get($name) {
      $method = 'get' . $name;
      if (('mapper' == $name) || !method_exists($this, $method)) {
          throw new Exception('Propriedade do exercise no get inválido');
      }

      return $this->$method();
  }

  public function setOptions(array $options) {
      $methods = get_class_methods($this);
      foreach ($options as $key => $value) {
          $method = 'set' . ucfirst($key);
          if (in_array($method, $methods)) {
              $this->$method($value);
          }
      }
      return $this;
  }

  public function getNomeClasse() {
      return 'Exercise';
  }

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  public function getId() {
      return $this->id;
  }

/**
  * @var string
  *
  * @ORM\Column(name="name", type="text")
  */
  protected $name;

  /**
   * Set name
   *use Symfony\Component\Filesystem\Filesystem;
   * @param string $name
   * @return Exercise
   */
  public function setName($name) {
      $this->name = $name;

      return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName() {
      return $this->name;
  }

  /**
    * @var string
    *
    * @ORM\Column(name="statement", type="text")
    */
    protected $statement;

    /**
     * Set statement
     *
     * @param string $statement
     * @return Exercise
     */
    public function setStatement($statement) {
        $this->statement = $statement;

        return $this;
    }

    /**
     * Get statement
     *
     * @return string
     */
    public function getStatement() {
        return $this->statement;
    }



    /**
      * @ORM\Column(name="modelResponse", type="text")
      */
    protected $modelResponse;

    /**
     * Set titulo
     *
     */
    public function setModelResponse($modelResponse) {
        $this->modelResponse = $modelResponse;

        return $this;
    }

    /**
     * Get titulo
     *
     */
    public function getModelResponse() {
        return $this->modelResponse;
    }

    /**
      * @ORM\Column(name="tests", type="text")
      */
    protected $tests;

    /**
     * Set titulo
     *
     */
    public function setTests($tests) {
        $this->tests = $tests;

        return $this;
    }

    /**
     * Get titulo
     *
     */

    public function getTests() {
      return $this->tests;
    }

    protected $code;

    /**
     * Set titulo
     *
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get titulo
     *
     */
    public function getCode() {
        return $this->code;
    }

    protected $testCode;

    protected $nameTestFile;

    public function buildCodeTest($code, $tests) {
        $this->testCode =
                "#include <stdio.h> \n"
                . "#include <stdlib.h> \n"
                . "#include \"CUnit/Basic.h\" \n"
                . $code
                . "int init_suite(void) { \n"
                . "return 0; \n"
                . "} \n"
                . "int clean_suite(void) { \n"
                . "return 0; \n"
                . "} \n"
                . "void testa" . $this->name . "() { \n"
                . $tests
                . "} \n"
                . "int main() { \n"
                . "CU_pSuite pSuite = NULL; \n"
                . "    if (CUE_SUCCESS != CU_initialize_registry()) \n"
                . "return CU_get_error(); \n"
                . "    pSuite = CU_add_suite(\"newcunittest\", init_suite, clean_suite); \n"
                . "if (NULL == pSuite) { \n"
                . "CU_cleanup_registry(); \n"
                . "return CU_get_error(); \n"
                . "} \n"
                . "if (NULL == CU_add_test(pSuite, \"testa" . $this->name . "\", testa" . $this->name . ")) { \n"
                . "CU_cleanup_registry(); \n"
                . "return CU_get_error(); \n"
                . "} \n"
                . "CU_basic_set_mode(CU_BRM_VERBOSE); \n"
                . "CU_automated_run_tests(); \n"
                . "CU_cleanup_registry(); \n"
                . "return CU_get_error(); \n"
                . "} \n";

                return $this->testCode;
    }

    public function buildSourceCode() {
        //try {
            //Compilação do código-fonte

            //$fileSystem = new FileSystem();

            $this->nameTestFile = "testMethod". $this->name;

            $caminhoTestFile = "exercises/". $this->nameTestFile;

            $fileTestFile = $caminhoTestFile . ".c";

            \shell_exec('rm -rf exercises/*');

            \file_put_contents($fileTestFile, $this->buildCodeTest($this->code, $this->tests) );
            $output =  \shell_exec("gcc " . $fileTestFile . " -lcunit -o " . $caminhoTestFile );
            \shell_exec('(cd exercises && exec ./'.$this->nameTestFile.')');

            $simpleXml = \simplexml_load_file('exercises/CUnitAutomated-Results.xml');

            //echo var_dump($simpleXml);

            $falhas = $simpleXml->CUNIT_RUN_SUMMARY[0]->CUNIT_RUN_SUMMARY_RECORD[2]->FAILED;

            $parcelas = 10/$simpleXml->CUNIT_RUN_SUMMARY[0]->CUNIT_RUN_SUMMARY_RECORD[2]->RUN;

            $nota = 10 - $parcelas*$falhas;

            return $nota;

          /*

            if (!result.equals("")) {
                //javax.swing.JOptionPane.showMessageDialog(null, "Tem erro de compilação");
                hasCompileErrors = true;
                if (countAttempts < 3) {
                    exerciseMark -= 0.5;
                    countAttempts += 1;
                } else {
                    endOfAttempts = true;
                }
            } else {
                assertProgram();
                //javax.swing.JOptionPane.showMessageDialog(null, "Nota testes de unidade : " + testMark);
                if (testMark == 0) {
                    exerciseMark = 0;
                } else {
                    //calculoDasMetricasEComparacaoComAsDaRespostaModelo();
                    calcExerciseMark();
                }
                //javax.swing.JOptionPane.showMessageDialog(null, "Nota Exercício : " + exerciseMark);
                //javax.swing.JOptionPane.showMessageDialog(null, "Exercicio enviado com sucesso. Vamos fazer o próximo exercicio");
                hasCompileErrors = false;

            }

            testFile.delete();
            metricsFile.delete();
            modelResponseFile.delete();

            */

        }
        /*catch (IOException e) {
            e.printStackTrace();
        }
        */



}
