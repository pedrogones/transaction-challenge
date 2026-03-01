<?php

namespace App\Presenters;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Laracasts\Presenter\Presenter;

class DefaultPresenter extends Presenter {


    public function getStatus()
    {
        return match ($this->status) {
            'Em processamento' => 'bg-yellow-100 text-yellow-700',
            'Aprovada' => 'bg-green-100 text-green-700',
            'Negada' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function createdFormatDate() {
        return $this->dateFormat($this->created_at);
    }

    public function updatedFormatDate() {
        return $this->dateFormat($this->updated_at);
    }

    public function createdFormatDateTime() {
        return $this->dateTimeFormat($this->created_at);
    }

    public function updatedFormatDateTime() {
        return $this->dateTimeFormat($this->updated_at);
    }

    function dateFormat( $data ) {
        return !is_null( $data ) ? $data->format('d/m/Y') : '';
    }

    function dateTimeFormat( $data ) {
        return !is_null( $data ) ? $data->format('d/m/Y H:i') : '';
    }

}
