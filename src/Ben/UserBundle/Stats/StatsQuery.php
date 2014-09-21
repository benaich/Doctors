<?php 
namespace Ben\UserBundle\Stats;

Class StatsQuery{
    
    private $dateFrom;
    private $dateTo;
    private $rangeDate;

    function __construct($daterange = null){
        $pattern = '#^[0-9]{4}/[0-9]{1,2}/[0-9]{1,2} - [0-9]{4}/[0-9]{1,2}/[0-9]{1,2}$#';
        $this->rangeDate = '';
        if (preg_match($pattern, $daterange)) {          
            $date = explode("-", $daterange);
            $this->dateFrom = $date[0];
            $this->dateTo = $date[1];
            $this->rangeDate .= (empty($this->dateFrom)) ? '' : " and c.created >= '".$this->dateFrom."'" ;
            $this->rangeDate .= (empty($this->dateTo)) ? '' : " and c.created <= '".$this->dateTo."'" ;
        }
    }

    public function getMeds()
    {
        return "select m.name as label, coalesce(sum(cm.count), 0 ) as data from meds m
            left join consultation_meds cm on cm.meds_id = m.id
            left join consultation c on cm.consultation_id = c.id
            where 1=1 {$this->rangeDate}
            group by m.id 
            union
            select 'total' as label,  sum(count) as data from consultation_meds cm
            left join consultation c on cm.consultation_id = c.id
            where 1=1 {$this->rangeDate}";
    }

    public function getConsultations()
    {
        return "select c.diagnosis as label, count(*) as data from consultation c where 1=1 {$this->rangeDate} group by label";
    }
    public function getStock()
    {
        return "select count(*) as data from meds c where 1=1 {$this->rangeDate}";
    }
    public function getGeneral_consultations()
    {
        return "select count(*) as data from consultation c where c.type = 'Consultation generale' {$this->rangeDate}";
    }
    public function getSpecial_consultations()
    {
        return "select count(*) as data from consultation c where c.type != 'Consultation generale' {$this->rangeDate}";
    }
    public function getOriented()
    {
        return "select count(*) as data from (select id from consultation c where c.type != 'Consultation generale' {$this->rangeDate} group by c.person_id)A";
    }

    /* Effectif des étudiants ayant une couverture sociale par type de couverture */
    public function getCnss()
    {
        return "select cnsstype as label, count(*) as data from person c where 1=1 {$this->rangeDate} group by label";
    }

    /* Nombre des consultations médicales à la demande */
    public function getConsultations_demande()
    {
        return "select count(*) as data from consultation c where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE' {$this->rangeDate}";
    }

    /* Nombre des consultations médicales à la demande par sexe */
    public function getConsultations_demande_gender()
    {
        return "select gender as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE' {$this->rangeDate} group by gender";
    }

    /* Nombre des résidents ayant subi une consultation médicale à la demande */
    public function getConsultations_demande_resident()
    {
        return "select count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE' and resident = true {$this->rangeDate}";
    }

    /* Nombre des résidents ayant subi une consultation médicale à la DEMANDE par sexe*/
    public function getConsultations_demande_resident_gender()
    {
        return "select gender as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE' and resident = true {$this->rangeDate} group by gender";
    }

    /* Nombre des résidents ayant subi un examen médical systématique  */
    public function getConsultations_systematique_resident()
    {
        return "select count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'EXAMEN MEDICAL SYSTEMATIQUE' and resident = true {$this->rangeDate}";
    }

    /* Nombre des résidents ayant subi un examen médical systématique par sexe  */
    public function getConsultations_systematique_resident_gender()
    {
        return "select gender as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'EXAMEN MEDICAL SYSTEMATIQUE' and resident = true {$this->rangeDate} group by gender";
    }

    /* Nombre de cas de troubles visuels corrigés et non corrigés */
    public function getConsultations_visual_issue()
    {
        return "select fixedvisualissue as label, count(*) as data from test left join consultation c on c.id = test.consultation_id where hasvisualissue = 1 {$this->rangeDate} group by fixedvisualissue";
    }

    /* Nombre des malades orientés vers la consultation médicale spécialisée par spécialité médicale */
    public function getConsultations_special()
    {
        return "select name as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where type = 'Consultation specialise' {$this->rangeDate} group by name";
    }

    /* Nombre des malades ayant subi une consultation médicale spécialisée par spécialité et par sexe  */
    public function getConsultations_special_gender()
    {
        return "select gender, name as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where type = 'Consultation specialise' {$this->rangeDate} group by name, gender";
    }
    
    /* Nombre  de cas des maladies dépistées */
    public function getConsultations_chronic()
    {
        return "select count(*) as data from consultation c where chronic = 1 {$this->rangeDate}";
    }
    
    /* Nombre  de cas des maladies dépistées */
    public function getConsultations_not_chronic()
    {
        return "select count(*) as data from consultation c where chronic = 0 {$this->rangeDate}";
    }
    
    /* Structures sanitaires de référence par structure */
    public function getConsultations_structures()
    {
        return "select infrastructure as label, count(*) as data from consultation c where type = 'Consultation specialise' {$this->rangeDate} group by label";
    }

    public function get($value)
    {
        return $this->{'get'.ucfirst($value)}();
    }
}