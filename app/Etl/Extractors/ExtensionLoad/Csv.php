<?php

namespace App\Etl\Extractors\ExtensionLoad;

use Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use App\Repositories\TemporaryWork\TemporalRepositoryContract;

class Csv extends ExtensionLoadBase implements ExtensionLoadContract
{
    /**
     * @var bool
     */
    public $dateTime = false;

    /**
     * @param TemporalRepositoryContract $repository
     * @param string $method
     * @param Collection $variables
     * @param string $fileName
     * @return bool
     */
    public function loadFormatData(TemporalRepositoryContract $repository, string $method, Collection $variables, string $fileName): bool
    {
        Excel::load(storage_path().'/app/public/'.$fileName, function(LaravelExcelReader $reader) use ($method,$variables,$repository) {

            $inputVariables = $reader->all()->getHeading();
            $variablesName = $this->getVariablesName($method, $inputVariables, $variables);
            $variablesNameExcel = array_keys($variablesName);

            # Se edita la propiedad data time
            $this->dateTime = in_array('date_time',$inputVariables);

            foreach ($reader->get() as $values){
                $val = [];
                $values->toArray();
                foreach ($inputVariables as $inputVariable){
                    if (in_array($inputVariable,$variablesNameExcel)){
                        $val[$variablesName[$inputVariable]] = $values[$inputVariable];
                    }
                }

                $repository->create($val);
            }
        });

        # cambiar de comas a puntos los datos de las variables
        $this->changeCommaForPointAllVariables($repository,$variables);

        return true;
    }

    /**
     * @return bool
     */
    public function isDateTime(): bool
    {
        return $this->dateTime;
    }

    /**
     * @param bool $dateTime
     */
    public function setDateTime(bool $dateTime): void
    {
        $this->dateTime = $dateTime;
    }
}