<?php

namespace App\Traits;

trait ModelTrait
{
    public function getKeyName()
    {
        return $this->Fadly_primaryKey ?? parent::getKeyName();
    }

    public function getFillable()
    {
        return $this->Fadly_fillable ?? [];
    }

    public function getDates()
    {
        return array_merge(parent::getDates(), $this->Fadly_dates ?? []);
    }

    public function usesTimestamps()
    {
        return $this->Fadly_timestamps ?? true;
    }

    public function getHidden()
    {
        return $this->Fadly_hidden ?? [];
    }

    public function getTable()
    {
        return $this->Fadly_table ?? parent::getTable();
    }

    public function getCasts()
    {
        return $this->Fadly_casts ?? [];
    }

    public function getGuarded()
    {
        return $this->Fadly_guarded ?? [];
    }




}
