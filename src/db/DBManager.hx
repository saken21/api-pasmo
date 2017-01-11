package db;

import haxe.Json;
import php.Web;
import db.table.*;

typedef Params = Map<String,String>;

class DBManager {

	private static var _results:Dynamic;

	/* =======================================================================
	Public - Get Results
	========================================================================== */
	public static function getResults(params:Params):String {

		Connector.init();

		_results = { status:0, message:ErrorMessage.NO_MODE, result:null };

		var mode:String = params['mode'];
		params.remove('mode');

		switch(mode) {

			case 'get'    : getList(params['card_id'],params['term']);
			case 'set'    : setHistory(params);
			case 'delete' : deleteHistory(params['id']);
			
		}

		return Json.stringify(_results);

	}
	
	/* =======================================================================
	Get List
	========================================================================== */
	private static function getList(cardID:String,term:String):Void {

		if (!Utils.existsParams([cardID,term])) {

			_results.message = ErrorMessage.NO_PROP + '(card_id,term)';
			return;
		
		}

		if (term > Utils.getThisTerm()) {

			_results.message = ErrorMessage.INVALID_TERM;
			return;

		}

		_results.result = {

			balance   : Balances.get(cardID,term),
			histories : Histories.get(cardID,term)

		};

		setSuccess();

	}

	/* =======================================================================
	Set History
	========================================================================== */
	private static function setHistory(params:Params):Void {

		if (!Utils.existsInMap(params,['card_id','term','price'])) {

			_results.message = ErrorMessage.NO_PROP + '(card_id,term,price)';
			return;

		}

		var term:String = params['term'];

		if (term > Utils.getThisTerm()) {

			_results.message = ErrorMessage.INVALID_TERM;
			return;

		}

		var id    :String = params['id'];
		var cardID:String = params['card_id'];
		var price :Int    = Std.parseInt(params['price']);

		params.remove('id');
		Histories.set(id,cardID,term,price,params);

		setSuccess();

	}

	/* =======================================================================
	Delete History
	========================================================================== */
	private static function deleteHistory(id:String):Void {

		if (!Utils.existsParams([id])) {

			_results.message = ErrorMessage.NO_PROP + '(id)';
			return;
		
		}

		Histories.delete(id);
		setSuccess();

	}

	/* =======================================================================
	Set Success
	========================================================================== */
	private static function setSuccess():Void {

		_results.status  = 1;
		_results.message = 'success';

	}

}