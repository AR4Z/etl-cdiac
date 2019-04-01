<?php

namespace App\Etl\Extractors\ExtensionLoad\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class PlaneImport implements ToCollection
{
    use Importable;

    /**
     * @var Collection
     */
    public $elements = null;

    /**
     * @var array
     */
    public $headers = [];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        # se extraen los elementos del archivo plano
        $this->elements = $collection;

        # se extraen los encabezados del array de elementos
        $this->setHeaders();
    }

    /**
     *
     */
    private function setHeaders()
    {
        if (is_null($this->elements)){ return;}

        $this->headers = $this->elements[0]->toArray();

        unset($this->elements[0]);
    }
}