<?php

class Hunter {

    public $ammo = 10;
    public $hungry = 0;
    public $travelled = 0;
    public $position = ['x' => 0, 'y' => 0];

    public function __construct($x_max, $y_max){
        $this->position['x'] = rand(0,$x_max);
        $this->position['y'] = rand(0,$y_max);
    }

    public function hunt()
    {


    }
}

class Rabbit{
    public $speed = 0;
    public $color = "white";
    public $travelled = 0;
    public $position = ['x' => 0, 'y' => 0];

    public function __construct($x_max, $y_max){
        $this->speed = rand(1,5);
        $this->color = rand(0,1) === 0 ? 'white' : 'brown';
        $this->position['x'] = rand(0,$x_max);
        $this->position['y'] = rand(0,$y_max);
    }

    public function chased()
    {

    }

}

class Hole{
    public $position = ['x' => 0, 'y' => 0];
    public $used = false;

    public function __construct($x_max, $y_max){
        $this->position['x'] = rand(0,$x_max);
        $this->position['y'] = rand(0,$y_max);
    }
}

class Forest{
    public $holes = [];
    public $rabbits = [];
    public $hunters = [];
    public $dimensions = ['x_max' => 0, 'y_max' => 0];
    public $surface = [];
    public $trees = 0;

    public function __construct(){
        $this->dimensions['x_max'] = rand(5,10);
        $this->dimensions['y_max'] = rand(5,10);

        // Init the surface
        $xs = range(0,$this->dimensions['x_max']);
        $ys = range(0,$this->dimensions['y_max']);
        foreach($xs as $x)
        {
            $this->surface[$x] = [];
            foreach($ys as $y)
            {
                $this->surface[$x][] = $y;
            }
        }

        // Adding hunters
        $hunters = rand(1,round(($this->dimensions['x_max']*$this->dimensions['y_max'])/4));
        for($i=0; $i < $hunters; $i++)
        {
            $this->add(new Hunter($this->dimensions['x_max'],$this->dimensions['y_max']));
        }

        // Adding rabbits
        $rabbits = rand(1,round(($this->dimensions['x_max']*$this->dimensions['y_max'])/2));
        for($i=0; $i < $rabbits; $i++)
        {
            $this->add(new Rabbit($this->dimensions['x_max'],$this->dimensions['y_max']));
        }

        // Adding Holes
        $holes = rand(0,round(($this->dimensions['x_max']*$this->dimensions['y_max'])/3));
        for($i=0; $i < $holes; $i++)
        {
            $this->add(new Hole($this->dimensions['x_max'],$this->dimensions['y_max']));
        }

    }


    private function add($item)
    {
        $type = strtolower(get_class($item)).'s';
        $this->{$type}[] = $item;
    }

    public function draw()
    {
        foreach($this->surface as $x => $ys)
        {
            foreach($ys as $y)
            {
                echo $this->checkBlock($x,$y) . " | ";
            }
            echo "\n";
        }
    }

    private function checkBlock($x,$y)
    {
        $found = "";

        $rabbits_here = array_filter($this->rabbits,function($rabbit) use($x,$y){
            return $rabbit->position['x'] == $x && $rabbit->position['y'] == $y;
        });
        $holes_here = array_filter($this->holes,function($hole) use($x,$y){
            return $hole->position['x'] == $x && $hole->position['y'] == $y;
        });
        $hunters_here = array_filter($this->hunters,function($hunter) use($x,$y){
            return $hunter->position['x'] == $x && $hunter->position['y'] == $y;
        });

        if(count($rabbits_here) > 0)
        {
            $found .= "R";
        }
        if(count($holes_here) > 0)
        {
            $found .= "H";
        }
        if(count($hunters_here) > 0)
        {
            $found .= "X";
        }

        $found = str_pad($found,3," ");

        return $found;
    }
}

// init the scene
$forest = new Forest();

$forest->draw();