
function goToURL() { //v3.0
  var i, args=goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}




/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


