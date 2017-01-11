package db;

import haxe.Json;
import sys.db.Connection;
import sys.db.ResultSet;
import php.Web;
import jp.saken.php.DB;
import php.db.PDO;

class Connector {
	
	private static var _connection:Connection;
	
	/* =======================================================================
	Public - Init
	========================================================================== */
	public static function init():Void {
		
		var hostName:String = Web.getHostName();
		var dbName  :String = 'pasmo';
		
		_connection = DB.getConnection(dbName);
		
	}
	
		/* =======================================================================
		Public - Select
		========================================================================== */
		public static function select(table:String,columns:String = 'id',params:Map<String,String> = null):String {

			var where:String = '';

			if (params != null) {
				where = Utils.getJoined(params);
			}

			return selectFully(table,columns,where);

		}
		
		/* =======================================================================
		Public - Select Fully
		========================================================================== */
		public static function selectFully(table:String,columns:String,where:String):String {
			
			if (where.length > 0) {
				where = ' where ' + where;
			}
			
			return request('select ' + columns + ' from ' + table + where);

		}

		/* =======================================================================
		Public - Update
		========================================================================== */
		public static function update(table:String,data:Map<String,String>,params:Map<String,String>):Void {

			if (!Utils.exists(select(table,'id',params))) {
				return insert(table,data);
			}

			request('update ' + table + ' set ' + Utils.getJoined(data,',') + ' where ' + Utils.getJoined(params));

		}
		
		/* =======================================================================
		Public - Calculate
		========================================================================== */
		public static function calculate(table:String,column:String,diff:Int,params:Map<String,String>):Void {
			
			var set  :String = ' set ' + column + ' = ' + column + ' + ' + diff;
			var where:String = ' where ' + Utils.getJoined(params);
			
			request('update ' + table + set + where);

		}
		
		/* =======================================================================
		Public - Concat
		========================================================================== */
		public static function concat(table:String,column:String,value:String,params:Map<String,String>):Void {
			
			var set  :String = ' set ' + column + ' = concat_ws(",",' + column + ',"' + value + '")';
			var where:String = ' where ' + Utils.getJoined(params) + ' and length(' + column + ') > 0';
			
			request('update ' + table + set + where);

		}

		/* =======================================================================
		Public - Insert
		========================================================================== */
		public static function insert(table:String,data:Map<String,String>):Void {

			var keys  :Array<String> = [];
			var values:Array<String> = [];

			for (key in data.keys()) {

				keys.push(key);
				values.push('"' + data[key] + '"');

			}
			
			request('insert into ' + table + ' (' + keys.join(',') + ') values (' + values.join(',') + ')');

		}

		/* =======================================================================
		Public - Delete
		========================================================================== */
		public static function delete(table:String,id:String):Void {

			request('delete from ' + table + ' where id = "' + id + '"');

		}
	
	/* =======================================================================
	Request
	========================================================================== */
	private static function request(sql:String):String {

		var resultSet:ResultSet = _connection.request(sql);
		return DB.getJSON(resultSet.results());

	}

}