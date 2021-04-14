/**
 * Similar to the Date (dd/mm/YY) data sorting plug-in, this plug-in offers 
 * additional  flexibility with support for spaces between the values and
 * either . or / notation for the separators.
 *
 * Please note that this plug-in is **deprecated*. The
 * [datetime](//datatables.net/blog/2014-12-18) plug-in provides enhanced
 * functionality and flexibility.
 *
 *  @name Date (dd . mm[ . YYYY]) 
 *  @summary Sort dates in the format `dd/mm/YY[YY]` (with optional spaces)
 *  @author [Robert SedovÅ¡ek](http://galjot.si/)
 *  @deprecated

 *
 *  @example

 *    $('#example').dataTable( {
 *       columnDefs: [
 *         { type: 'date-eu', targets: 0 }
 *       ]
 *    } );
 */

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
	"date-eu-pre": function ( date ) {
            date = date.replace(" ", "");

            if ( ! date ) {
                return 0;
            }

            var year;
            var eu_date = date.split(/[\.\-\/]/);

            /*year (optional)*/
            if ( eu_date[2] ) {
                year = eu_date[2];
            }
            else {
                year = 0;
            }

            /*month*/
            var month = eu_date[1];
            if ( month.length == 1 ) {
                month = 0+month;
            }

            /*day*/
            var day = eu_date[0];
            if ( day.length == 1 ) {
                day = 0+day;
            }

            var hour = "00";
            var minute = "00";
            var second = "00";
            if (eu_date.length > 3){
                var ue_dateHourMinSeg = eu_date[3];
                ue_dateHourMinSeg = ue_dateHourMinSeg.replace(/^\s+|\s+$/g, "");
                var hourMinSeg = ue_dateHourMinSeg.split(/[\:\/]/);
                if (hourMinSeg.length === 3){
                    hour = hourMinSeg[0];
                    minute = hourMinSeg[1];
                    second = hourMinSeg[2];
                }
                else{
                    if (hourMinSeg.length === 2){
                        hour = hourMinSeg[0];
                        minute = hourMinSeg[1];                            
                    }                        
                }
            }

            return (year + month + day + hour + minute) * 1;
	},

	"date-eu-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	},

	"date-eu-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	}
} );