<?php
class UserData extends CActiveRecord{
	
	public $id;
	public $name;
	public $birthday;
	public $location;
	public $sex;
	public $homepage;
	public $description;
	
	public function tableName(){
		return 'users_data';
	}
	
	public function rules(){
		return array(			
		);
	}
	
	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
	public function setAttributes($attributes) {
        foreach ($attributes as $attribute=>$value) {
            if (property_exists( get_class ($this), $attribute)) {
                $this->$attribute = $value;
            } else {
                $this->dynamic_attributes[$attribute] = $value;
            }
        }
    }
}
