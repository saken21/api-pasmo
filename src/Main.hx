/**
* ================================================================================
*
* Pasmo API ver 1.00.00
*
* Author : Kenta Sakata
* Since  : 2017/01/11
* Update : 2017/01/18
*
* Licensed under the MIT License
* Copyright (c) Kenta Sakata
* http://saken.jp/
*
* ================================================================================
*
**/
package;

import php.Web;
import php.Lib;
import db.DBManager;

class Main {
	
	public static function main():Void {
		
		Lib.print(DBManager.getResults(Web.getParams()));
		
	}

}