function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write(
		'<table cellpadding="0" cellspacing="0" border="0" style="width:98%"><tr>' +
		'<td class="td" valign="top">' +

		'<ul>' +
		'<li><a href="'+base+'index.html">User Guide Home</a></li>' +
		'<li><a href="'+base+'callers.html">Callers</a></li>' +
		'</ul>' +

		

		
		
		
		
		'</td><td class="td_sep" valign="top">' +

		'<h3>Classes</h3>' +
		'<ul>' +
			'<li><a href="'+base+'databases.html">Databases</a></li>' +
			'<li><a href="'+base+'pagination.html">Pagination</a></li>' +	
			'<li><a href="'+base+'logs.html">Logs</a></li>' +
			'<li><a href="'+base+'curl.html">Curl</a></li>' +
			'<li><a href="'+base+'imaging.html">Imaging</a></li>' +
			'<li><a href="'+base+'html_output.html">HTML Output</a></li>' +
			'<li><a href="'+base+'captchca.html">Captchca</a></li>' +
			'<li><a href="'+base+'file_uploading.html">File Uploading</a></li>' +
			'<li><a href="'+base+'feed_reader.html">Feed Reader</a></li>' +		
			
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +
		'<h3>Helper Classes</h3>' +
		'<ul>' +
			'<li><a href="'+base+'input_helpers.html">Input Helper</a></li>' +
			
		'</ul>' +



		'</td></tr></table>');
}