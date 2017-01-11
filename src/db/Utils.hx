package db;

import haxe.Json;

class Utils {
	
	/* =======================================================================
	Public - Get Joined
	========================================================================== */
	public static function getJoined(map:Map<String,String>,separator:String = ' and '):String {
		
		var array:Array<String> = [];
		
		for (key in map.keys()) {
			array.push(key + ' = "' + map[key] + '"');
		}
		
		return array.join(separator);

	}
	
		/* =======================================================================
		Public - Exists
		========================================================================== */
		public static function exists(value:String):Bool {

			return Json.parse(value).length > 0;

		}

		/* =======================================================================
		Public - Exists In Map
		========================================================================== */
		public static function existsInMap(map:Map<String,Dynamic>,keys:Array<String>):Bool {

			for (i in 0...keys.length) {

				if (!map.exists(keys[i])) {
					return false;
				}

			}

			return true;

		}
		
		/* =======================================================================
		Public - Exists Params
		========================================================================== */
		public static function existsParams(array:Array<String>):Bool {
			
			for (i in 0...array.length) {
				if (array[i] == null) return false;
			}

			return true;

		}

		/* =======================================================================
		Public - Get Now
		========================================================================== */
		public static function getNow():String {

			return Date.now().toString();

		}

		/* =======================================================================
		Public - Get This Term
		========================================================================== */
		public static function getThisTerm():String {

			return getTerm();

		}
		
		/* =======================================================================
		Public - Get Last Term
		========================================================================== */
		public static function getLastTerm():String {

			return getTerm(1);

		}
	
	/* =======================================================================
	Get Term
	========================================================================== */
	private static function getTerm(past:Int = 0):String {
		
		var date:Date = Date.now();
		var y   :Int  = date.getFullYear();
		var m   :Int  = date.getMonth() + 1;
		var d   :Int  = date.getDate();
		
		m -= past;
		
		if (m < 1) {
			
			y--;
			m = 12;
			
		}
		
		return y + Std.string((m < 10) ? '0' + m : m);

	}

}