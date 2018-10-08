<?php

class Company{
    public $offices = [];

    /**
     * @param Office $office
     * @return Company
     */
    public function addOffice(Office $office)
    {
        $this->offices[] = $office;

        return $this;
    }

    /**
     * Add a new employee in an $service
     * @param $service string The service is the classname of the office
     * @return bool
     */
    public function addEmployee($service)
    {
        $added = false;

        foreach($this->offices as $office)
        {
            if(get_class($office) == $service && !$office->isFull())
            {
                $office->people++;
                $added = true;
                break;
            }
        }
        return $added;
    }

    /**
     * Return the number of employee in an service
     * @param $service
     * @return int
     */
    public function countEmployee($service){
        $employee = 0;
        foreach($this->offices as $office)
        {
            if(get_class($office) == $service)
            {
                $employee += $office->people;
            }
        }
        return $employee;
    }

    /**
     * Set random values for all offices in the company
     */
    public function setRandomValuesForOffices()
    {
        array_walk($this->offices,function(Office $office){
            $office->setRandomValues();
        });
    }

    /**
     * Get the total available space rate for the entire company
     * @return int
     */
    public function getTotalAvailableSpaceRate(){
        $availableSpaceRate = 0;
        foreach($this->offices as $office) {
            $availableSpaceRate += $office->getAvailableSpaceRate();
        }

        return $availableSpaceRate;
    }

    /**
     * Is the company full ?
     * @return bool
     */
    public function isFull(){
        $full = true;
        foreach($this->offices as $office) {
            if(!$office->isFull())
            {
                $full = false;
                break;
            }
        }

        return $full;
    }
}

class Office{

    public $lan_outlets = 0;
    public $power_outlets = 0;
    public $phone_outlets = 0;
    public $chairs = 0;
    public $tables = 0;
    public $people = 0;

    /**
     * Get the avaiable space rate in the office
     * @return int
     */
    public function getAvailableSpaceRate(){
        return round(($this->people - $this->lan_outlets) + ($this->people - $this->power_outlets) +
            ($this->people - $this->phone_outlets) +($this->people - $this->chairs) +
            ($this->people - $this->tables));
    }

    /**
     * Setting random values for the outlets, chairs and tables
     */
    public function setRandomValues(){
        $this->lan_outlets = mt_rand(5,15);
        $this->power_outlets = mt_rand(5,10);
        $this->phone_outlets = mt_rand(5,15);
        $this->chairs = mt_rand(5,12);
        $this->tables = mt_rand(5,14);
    }

    /**
     * Is the office full ?
     * To know if the office is full we have to simulate adding an Employee.
     * If adding an employee makes the space rate > 0, it means that the office cannot host more employee
     * @return bool
     */
    public function isFull()
    {
        $this->people++;
        $full = $this->getAvailableSpaceRate() > 0;
        $this->people--;

        return $full;
    }
}

class SalesOffice extends Office{

    public function getAvailableSpaceRate(){
        return round(($this->people - (3*$this->lan_outlets)) + ($this->people - (3*$this->power_outlets)) +
            ($this->people - $this->phone_outlets) +($this->people - (1.5*$this->chairs)) +
            ($this->people - $this->tables));
    }
}

class DeveloperOffice extends Office{

    /**
     * Get the avaiable space rate in the office, rounded to the nearest whole number
     * @return int
     */
    public function getAvailableSpaceRate(){
        return round(($this->people - $this->lan_outlets) + ($this->people - $this->power_outlets) +
            ($this->people - (2*$this->phone_outlets)) +($this->people - (1.5*$this->chairs)) +
            ($this->people - $this->tables));
    }
}



// Setting the company
$company = new Company();

// Setting 3 sales offices
$company->addOffice(new SalesOffice())->addOffice(new SalesOffice())->addOffice(new SalesOffice());

// Setting 2 developer offices
$company->addOffice(new DeveloperOffice())->addOffice(new DeveloperOffice());

// Setting random values for the company's offices
$company->setRandomValuesForOffices();

// Adding Employees
while(!$company->isFull())
{
    // 0. Developers. 1. Salesman
    $new_employee_office = rand(0,1) == 0 ? 'DeveloperOffice' : 'SalesOffice';
    $company->addEmployee($new_employee_office);

    // Output
    echo "\n-----------------------\n";
    echo "Developers : ".$company->countEmployee('DeveloperOffice')."\n";
    echo "Salesman : ".$company->countEmployee('SalesOffice')."\n";

    foreach($company->offices as $k => $office)
    {
        echo get_class($office)." ".($k+1)." : ".$office->getAvailableSpaceRate()."\n";
    }

    echo "Company available space rate : ".$company->getTotalAvailableSpaceRate()."\n";
}

echo "No more space available\n";


