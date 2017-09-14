<?php

/**
 * Description of lib
 *
 * @author ::
 * @Modified By :: kallol basu
 * 
 * Working with XML. Usage: 
 *   $xml=xml_to_array($xml_string);
 * 
 *   $link=&$xml['ddd']['_child'];
 * 
 * // insert_into_array(); // dot not insert a link, and arrays with links inside!   
 *
 *   echo array_to_xml($xml);
 * 
 *   echo xml_to_array($xml);   
 */
namespace XML_To_Array;

class XML_Array {
    
    //XML to Array
    public function xml_to_array(&$string) {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parse_into_struct($parser, $string, $vals, $index);
        xml_parser_free($parser);

        $master_array_xml=array();
        $array_xml=&$master_array_xml;
        foreach ($vals as $temp_row) {
            $temp_tag=$temp_row['tag'];
            if ($temp_row['type']=='open') {
                if (isset($array_xml[$temp_tag])) {
                    if (isset($array_xml[$temp_tag][0])) $array_xml[$temp_tag][]=array(); else $array_xml[$temp_tag]=array($array_xml[$temp_tag], array());
                    $child_value=&$array_xml[$temp_tag][count($array_xml[$temp_tag])-1];
                } else $child_value=&$array_xml[$temp_tag];
                if (isset($temp_row['attributes'])) {foreach ($temp_row['attributes'] as $temp_key=>$v) $child_value['_attribute'][$temp_key]=$v;}
                $child_value['_child']=array();
                $child_value['_child']['_p']=&$array_xml;
                $array_xml=&$child_value['_child'];

            } elseif ($temp_row['type']=='complete') {
                if (isset($array_xml[$temp_tag])) { // same as open
                    if (isset($array_xml[$temp_tag][0])) $array_xml[$temp_tag][]=array(); else $array_xml[$temp_tag]=array($array_xml[$temp_tag], array());
                    $child_value=&$array_xml[$temp_tag][count($array_xml[$temp_tag])-1];
                } else $child_value=&$array_xml[$temp_tag];
                if (isset($temp_row['attributes'])) {foreach ($temp_row['attributes'] as $temp_key=>$v) $child_value['_attribute'][$temp_key]=$v;}
                $child_value['_value']=(isset($temp_row['value']) ? $temp_row['value'] : '');

            } elseif ($temp_row['type']=='close') {
                $array_xml=&$array_xml['_p'];
            }
        }    

        $this->_del_p($master_array_xml);
        return $master_array_xml;
    }
    
    //_Internal: Remove recursion in result array
    private function _del_p(&$array_xml) {
        foreach ($array_xml as $temp_key=>$v) {
            if ($temp_key==='_p') unset($array_xml[$temp_key]);
            elseif (is_array($array_xml[$temp_key])) $this->_del_p($array_xml[$temp_key]);
        }
    }
    
    // Array to XML
    public function array_to_xml($array_to_process, $d=0, $forcetag='') {
        $temp_rowes=array();
        foreach ($array_to_process as $tag=>$temp_row) {
            if (isset($temp_row[0])) {
                $temp_rowes[]=  $this->xml_to_array($temp_row, $d, $tag);
            } else {
                if ($forcetag) $tag=$forcetag;
                $sp=str_repeat("\t", $d);
                $temp_rowes[]="$sp<$tag";
                if (isset($temp_row['_attribute'])) {foreach ($temp_row['_attribute'] as $at=>$av) $temp_rowes[]=" $at=\"$av\"";}
                $temp_rowes[]=">".((isset($temp_row['_child'])) ? "\n" : '');
                if (isset($temp_row['_child'])) $temp_rowes[]= $this->array_to_xml($temp_row['_child'], $d+1);
                elseif (isset($temp_row['_value'])) $temp_rowes[]=$temp_row['_value'];
                $temp_rowes[]=(isset($temp_row['_child']) ? $sp : '')."</$tag>\n";
            }

        }
        return implode('', $temp_rowes);
    }

    // Insert element into Array
    public function insert_into_array(&$array_xml, $element, $pos) {
        $ar1=array_slice($array_xml, 0, $pos); $ar1[]=$element;
        $array_xml=array_merge($ar1, array_slice($array_xml, $pos));
    }
}

?>
