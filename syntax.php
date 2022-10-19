<?php
/**
 * Plugin qrcodescanner
 * author: dodotori @dokuwiki forum
 * a dokuwiki scanner for bureaucracy form html5-qrcode library
 */
 
// must be run within DokuWiki
if(!defined('DOKU_INC')) die();
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */

class syntax_plugin_qrcodescanner extends DokuWiki_Syntax_Plugin {
    

    
    
    public function getType() { return 'substition'; }
    public function getSort() { return 32; }
 
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{QRCODESCANNER\}\}',$mode,'plugin_qrcodescanner');
    }
 
    public function handle($match, $state, $pos, Doku_Handler $handler) {
        return array($match, $state, $pos);
    }
 
    public function render($mode, Doku_Renderer $renderer, $data) {
    // $data is what the function handle return'ed.
        if($mode == 'xhtml'){
            /** @var Doku_Renderer_xhtml $renderer */
            $renderer->doc .= '<div id="reader" style="width:100%"></div>';
            $renderer->doc .= '<script src="https://unpkg.com/html5-qrcode"></script>';
            $renderer->doc .= '<script>
 
function onScanSuccess(decodedText, decodedResult) {
  // handle the scanned code as you like, for example:
  console.log(`Code matched = ${decodedText}`, decodedResult);
  document.getElementsByName("bureaucracy[1]")[0].value = `${decodedText}`, decodedResult;
}

let qrconfig = {
  fps: 10,
  qrbox: {width: 300, height: 300},
  rememberLastUsedCamera: true,
  //formatsToSupport: [ Html5QrcodeSupportedFormats.CODE_39 ]
  // Only support camera scan type.
};

let html5QrcodeScanner = new Html5QrcodeScanner(
  "reader", qrconfig);
    
html5QrcodeScanner.render(onScanSuccess);

    
</script>';
            
                     
            return true;
        }
        return false;
    }
}