package db.table;

import haxe.Json;
import db.DBManager;

class Histories {
	
	private static inline var TABLE_NAME  :String = 'histories';
	private static inline var FULL_COLUMNS:String = 'id,card_id,term,history_date,client,transportation,departure,destination,is_round,price,comment,is_charge,last_modified_time';

	/* =======================================================================
	Public - Get
	========================================================================== */
	public static function get(id:String):Dynamic {
		
		return Json.parse(select(FULL_COLUMNS,['id'=>id]))[0];

	}

		/* =======================================================================
		Public - Get List
		========================================================================== */
		public static function getList(cardID:String,term:String):Dynamic {
			
			return Json.parse(select(FULL_COLUMNS,['card_id'=>cardID,'term'=>term],' order by history_date asc'));

		}

		/* =======================================================================
		Public - Set
		========================================================================== */
		public static function set(id:String,cardID:String,term:String,price:Int,params:Params):Void {

			params['last_modified_time'] = Utils.getNow();

			if (id != null && Utils.exists(select('id',['id'=>id]))) {
				update(id,cardID,term,price,params);
			} else {
				insert(cardID,term,price,params);
			}

		}

		/* =======================================================================
		Public - Delete
		========================================================================== */
		public static function delete(id:String):Void {

			returnBalance(id);
			Connector.delete(TABLE_NAME,id);

		}

	/* =======================================================================
	Select
	========================================================================== */
	private static function select(columns:String,params:Map<String,String> = null,option:String = ''):String {
		
		return Connector.select(TABLE_NAME,columns,params,option);
		
	}

	/* =======================================================================
	Update
	========================================================================== */
	private static function update(id:String,cardID:String,term:String,price:Int,params:Params):Void {

		returnBalance(id);

		Balances.cutdown(cardID,term,price);
		Connector.update(TABLE_NAME,params,['id'=>id]);
		
	}

	/* =======================================================================
	Insert
	========================================================================== */
	private static function insert(cardID:String,term:String,price:Int,params:Params):Void {
		
		Balances.cutdown(cardID,term,price);
		Connector.insert(TABLE_NAME,params);
		
	}

	/* =======================================================================
	Return Balance
	========================================================================== */
	private static function returnBalance(id:String):Void {

		var last:Dynamic = Json.parse(select('card_id,term,price',['id'=>id]))[0];
		Balances.add(last.card_id,last.term,Std.parseInt(last.price));
		
	}

}