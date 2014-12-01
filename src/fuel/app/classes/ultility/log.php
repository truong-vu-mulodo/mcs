<?php
/**
 * Ultility functions for about logging.
 *
 * @author Vu Truong
 * @since 2014/11/03
 */
class Ultility_Log {

    /**
     * Constructor.
     */
    public function __construct() {
    }
    
    /**
     * Write info, debug, warning, error to log file.
     * 
     * @param int $level Log level. Should be Fuel::L_INFO, Fuel::L_DEBUG, Fuel::L_WARNING, Fuel::L_ERROR
     * @param Exception $ex Exception object
     * @param string $method Called function name
     */
    public static function log($level, $input = array(), $function = null) {
    	// In case of an exception
    	if (!is_array($input)) {
    		// Build up log message
    		$message = '';
    		$message .= $input->getFile();
    		$message .= ' ';
    		$message .= $input->getLine();
    		$message .= ' ';
    		$message .= $input->getMessage();
    		$message .= ' ';
    		// $message .= $ex->getTraceAsString();
    	// In case of an messages array
    	} else {
    		$message = $input[0];
    	}
    	
    	// Write to file
    	switch ($level) {
    		case Fuel::L_INFO: {
    			Log::info($message, $function);
    			break;
    		}
    		case Fuel::L_DEBUG: {
    			Log::debug($message, $function);
    			break;    			 
    		}    		
    		case Fuel::L_WARNING: {
    			Log::warning($message, $function);
    			break;    		
    		}
    		case Fuel::L_ERROR: {
    			Log::error($message, $function);
    			break;
    		}
    		default:
    			break;
    	}
    }

}
?>