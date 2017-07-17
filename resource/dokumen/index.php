<!-- 201605241144, 201605181411, 201606021656 - Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id> -->
<!DOCTYPE html><html><title>Manual Developer</title>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.1.1/normalize.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/highlight.js/9.4.0/styles/gruvbox-dark.min.css"/>
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'/>
<style>
	body {
		background-color: #eee;
	}
	#manualdev {
		position: relative;
		font-family: 'Ubuntu', sans-serif;
		padding: 32px 72px;
		margin: 0px;
	}
	#manualdev > h1,
	#manualdev > h2,
	#manualdev > h3 {
		margin-top: 8px;
		margin-bottom: 0px;
	}
	#manualdev > p code {
		color: #8C1C13;
		background-color: rgba(140, 28, 19, 0.1);
		padding-left: 4px;
		padding-right: 4px;
	}
	#toc {
		font-family: 'Ubuntu', sans-serif;
		position: fixed;
		top: 8px;
		right: 8px;
		padding: 8px;
		background-color: rgba(255,255,255,0.8);
		border: 1px solid #222;
		z-index: 999;
		opacity: 0.2;
	}
	#toc:hover {
		opacity: 1;
	}
	#toc a {color: #0099ff;}
</style>

<div id="toc"></div>
<div id="manualdev" style="display:none;"></div>

<script src="//cdnjs.cloudflare.com/ajax/libs/markdown-it/6.0.2/markdown-it.min.js"></script>
<script src="//cdn.jsdelivr.net/highlight.js/9.4.0/highlight.min.js"></script>
<script>
	// console.log()
	// http://stackoverflow.com/questions/168214/pass-a-php-string-to-a-javascript-variable-and-escape-newlines/169035#169035
	var content = <?php echo json_encode(file_get_contents('dokumentasi.md')) ?>;
	var md = markdownit(),
	toc = document.getElementById('toc'),
	manualdev = document.getElementById('manualdev');

	manualdev.innerHTML = md.render(content);
	manualdev.style.display = '';

	setTimeout(function() {
		function hash_section(elm) {
			var elm_id = elm.innerText.toLowerCase().replace(/[^\w ]+/g,'').replace(/\s+/g,'-');
			elm.id = elm_id;
			toc.innerHTML += "<a href='#"+elm_id+"'>"+elm.innerText+"</a><br/>";
		}
		for (var i = 0; i < manualdev.children.length; i++) {
			if(/^H\d/.test(manualdev.children[i].nodeName)) {
				hash_section(manualdev.children[i]);
			}
		}

		for (var i = 0; i < document.links.length; i++) {
			if(document.links[i].parentElement.id !== "toc") {
				document.links[i].target = "_blank";
			}
		}
	},0);

	hljs.initHighlighting();
</script>
</html>