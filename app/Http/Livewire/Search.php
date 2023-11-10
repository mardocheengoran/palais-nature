<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class Search extends Component
{
    public $showdiv = false;
    public $search = "";
    public $records;

    public function render()
    {
        return view('livewire.search');
    }

    public function searchResult()
    {
        if(!empty($this->search)){
            $this->records = Article::whereRubric_id(125)
            ->orderby('title', 'asc')
            ->select('*')
            ->where('title','like','%'.$this->search.'%')
            ->limit(5)
            ->get();
            $this->showdiv = true;
        }else{
            $this->showdiv = false;
        }
    }
}
