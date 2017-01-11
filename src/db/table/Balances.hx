package db.table;

import haxe.Json;

class Balances {
	
	private static inline var TABLE_NAME  :String = 'balances';
	private static inline var FULL_COLUMNS:String = 'id,card_id,term,value,last_modified_time';

	/* =======================================================================
	Public - Get
	========================================================================== */
	public static function get(cardID:String,term:String):String {

		var json:Array<Dynamic> = Json.parse(select('value',['card_id'=>cardID,'term'=>term]));
		if (json.length > 0) return json[0].value;

		var lastTerm:String = Reflect.getProperty(Json.parse(select('max(term)',['card_id'=>cardID]))[0],'max(term)');
		var value   :String = Json.parse(select('value',['card_id'=>cardID,'term'=>lastTerm]))[0].value;

		insert(cardID,term,value);

		return value;

	}
	
		/* =======================================================================
		Public - Cutdown
		========================================================================== */
		public static function cutdown(cardID:String,term:String,diff:Int):Void {
			
			Connector.calculate(TABLE_NAME,'value',-diff,['card_id'=>cardID,'term'=>term]);

		}

		/* =======================================================================
		Public - Add
		========================================================================== */
		public static function add(cardID:String,term:String,diff:Int):Void {
			
			cutdown(cardID,term,-diff);

		}

	/* =======================================================================
	Select
	========================================================================== */
	private static function select(columns:String,params:Map<String,String> = null):String {
		
		return Connector.select(TABLE_NAME,columns,params);
		
	}

	/* =======================================================================
	Insert
	========================================================================== */
	private static function insert(cardID:String,term:String,value:String):Void {
		
		Connector.insert(TABLE_NAME,['card_id'=>cardID,'term'=>term,'value'=>value,'last_modified_time'=>Utils.getNow()]);
		
	}

}