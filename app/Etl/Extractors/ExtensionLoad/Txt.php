<?php

namespace App\Etl\Extractors\ExtensionLoad;

use Illuminate\Support\Collection;
use App\Repositories\TemporaryWork\TemporalRepositoryContract;

class Txt extends ExtensionLoadBase implements ExtensionLoadContract
{

    public $extension = 'csv';

    /**
     * @var bool
     */
    private $dateTime = true;

    /**
     * @param TemporalRepositoryContract $repository
     * @param string $method
     * @param Collection $variables
     * @param string $fileName
     * @return bool
     */
    public function loadFormatData(TemporalRepositoryContract $repository, string $method,Collection $variables,string $fileName) : bool
    {
        # Se lee el archivo
        $file = file(storage_path().'/app/public/'. $fileName,FILE_IGNORE_NEW_LINES);

        # Extraer los encabezados del archivo text delimitado por comas
        $inputVariables = explode(",",$file[0]);

        # Se eliminan los encabezados el array del archivo
        unset($file[0]);

        # Se cargan las variables dependiendo de las variables cargadas
        $variablesName = $this->getVariablesName($method, $inputVariables, $variables);

        # Se edita la propiedad data time
        $this->dateTime = in_array('date_time',$inputVariables);



        # Se buscan los encabezados entrantes y se obtiene el nombre en la tabla temporal
        $headers = [];
        foreach ($inputVariables as $inputVariable){
            if (array_key_exists($inputVariable,$variablesName)){array_push($headers,$variablesName[$inputVariable]);}
        }

        # Se genera el array para insertar en la tabla temporal
        $data = [];
        foreach ($file as $row) {
            array_push($data,array_combine($headers,explode(",",$row)));
        }

        return $repository->queryBuilder()->insert($data);
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