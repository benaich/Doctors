<?php 
namespace Ben\UserBundle\Stats;

Class StatsQuery{
    
    private $dateFrom;
    private $dateTo;

    function __construct($daterange = null){
        $pattern = '#^[0-9]{4}/[0-9]{1,2}/[0-9]{1,2} - [0-9]{4}/[0-9]{1,2}/[0-9]{1,2}$#';
        if (preg_match($pattern, $daterange)) {          
            $date = explode("-", $daterange);
            $this->dateFrom = $date[0];
            $this->dateTo = $date[1];
        }
    }

    public function getMeds()
    {
        $query = "select m.name as label, coalesce(sum(cm.count), 0 ) as data from meds m
            left join consultation_meds cm on cm.meds_id = m.id
            left join consultation c on cm.consultation_id = c.id
            where 1=1";
        $query .= (empty($this->dateFrom)) ? '' : " and c.created >= '".$this->dateFrom."'" ;
        $query .= (empty($this->dateTo)) ? '' : " and c.created <= '".$this->dateTo."'" ;
        
        $query .= " group by m.id 
            union
            select 'total' as label,  sum(count) as data from consultation_meds cm
            left join consultation c on cm.consultation_id = c.id
            where 1=1";
        $query .= (empty($this->dateFrom)) ? '' : " and c.created >= '".$this->dateFrom."'" ;
        $query .= (empty($this->dateTo)) ? '' : " and c.created <= '".$this->dateTo."'" ;
        
        return $query;
    }

    public function getConsultations()
    {
        $query =  "select c.diagnosis as label, count(*) as data from consultation c where 1=1";
        $query .= (empty($this->dateFrom)) ? '' : " and c.created >= '".$this->dateFrom."'" ;
        $query .= (empty($this->dateTo)) ? '' : " and c.created <= '".$this->dateTo."'" ;
        $query .= " group by label";

        return $query;
    }
    public function getStock()
    {
        $query =  "select count(*) as label from meds m where 1=1";
        $query .= (empty($this->dateFrom)) ? '' : " and m.created >= '".$this->dateFrom."'" ;
        $query .= (empty($this->dateTo)) ? '' : " and m.created <= '".$this->dateTo."'" ;

        return $query;
    }
    public function getGeneral_consultations()
    {
        $query =  "select count(*) as label from consultation c where c.type = 'Consultation generale'";
        $query .= (empty($this->dateFrom)) ? '' : " and c.created >= '".$this->dateFrom."'" ;
        $query .= (empty($this->dateTo)) ? '' : " and c.created <= '".$this->dateTo."'" ;

        return $query;
    }
    public function getSpecial_consultations()
    {
        $query =  "select count(*) as label from consultation c where c.type != 'Consultation generale'";
        $query .= (empty($this->dateFrom)) ? '' : " and c.created >= '".$this->dateFrom."'" ;
        $query .= (empty($this->dateTo)) ? '' : " and c.created <= '".$this->dateTo."'" ;

        return $query;
    }
    public function getOriented()
    {
        $query =  "select count(*) as label from (select id from consultation c where c.type != 'Consultation generale'";
        $query .= (empty($this->dateFrom)) ? '' : " and c.created >= '".$this->dateFrom."'" ;
        $query .= (empty($this->dateTo)) ? '' : " and c.created <= '".$this->dateTo."'" ;
        $query .= " group by c.person_id)A";

        return $query;
    }
    public function get($value)
    {
        return $this->{'get'.ucfirst($value)}();
    }
}