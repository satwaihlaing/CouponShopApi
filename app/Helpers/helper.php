<?php

if (! function_exists('default_limit')) {
	
	function default_limit($limit)
	{
		if(!$limit){
            return 30; 
        }
        return $limit;
	}
}

if (! function_exists('default_offset')) {
	
	function default_offset($offset)
	{
		if(!$offset){
            return 0; 
        }
        return $offset;
	}
}