/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Financeiro() {

    var nome;
    var idade;
    var curso;
    var n, c, d, t, finalNum;
    var numUS;
    var idOne, idTwo, nValor, nPorce, calcTotal;
    var classTag;
    var url;



    this.setNome = function (nome) {
        this.nome = nome;
    };

    this.setIdade = function (idade) {
        this.idade = idade;
    };

    this.setCurso = function (curso) {
        this.curso = curso;
    };
    
    // usando   formatMoney(100000, 2, '.', ',') //retorna 1.000,00
    this.setMoneyCash = function (vN, vC, vD, vT) {
        this.n = vN;
        this.c = vC;
        this.d = vD;
        this.t = vT;  
    };
    
    this.setClear = function (numClear){
        this.numClear = numClear;
    };
    
    // Recebe um numero que contem virgula e substitui po ponto
    this.setUS = function (numUS) {
        this.numUS = numUS;
    };
    
    this.setNumberCalc = function (idOne, idTwo) {
        this.idOne = idOne;
        this.idTwo = idTwo;
        this.nValor;
        this.nPorce;
        this.calcTotal;
    };
    
    this.setAjaxData = function ( url ) {
        this.url = url;
    };
    
    this.setAjaxFilter = function ( url ) {
        this.url = url;
    };
    
    this.setAjaxEditRegister = function ( id ) {
        this.id = id;
    };
    

    this.getNome = function () {
        return this.nome;
    };

    this.getIdade = function () {
        return this.idade;
    };

    this.getCurso = function () {
        return this.curso;
    };
    
    this.getMoneyCash = function () {
        return this.finalNum;
    };

    this.getClear = function () {
        return this.numClear;
    };
    
    this.getUS = function () {
        return this.numUS;
    };
    
    this.getNumberCalc = function () {
        if(this.calcTotal){
            return this.calcTotal;
        }else{
            return this.calcTotal = '0,00';
        }
    };
    
    this.getAjaxData = function () {
        return this.url;
    };
    
    this.getAjaxFilter = function () {
        return this.url;
    };
    
    this.getAjaxEditRegister = function () {
        return this.id;
    };

    this.mostraDados = function () {
        alert("Nome do aluno: " + this.nome + "\nIdade: " + this.idade + "\nCurso: " + this.curso);
    };

    this.formatMoneyCash = function () {
        this.c = isNaN(this.c = Math.abs(this.c)) ? 2 : this.c, this.d = this.d == undefined ? "," : this.d, this.t = this.t == undefined ? "." : this.t, s = this.n < 0 ? "-" : "", i = parseInt(this.n = Math.abs(+this.n || 0).toFixed(this.c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return this.finalNum  = (s + (j ? i.substr(0, j) + this.t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + this.t) + (this.c ? this.d + Math.abs(this.n - i).toFixed(this.c).slice(2) : ""));
    };
    
    this.clearNumber = function (){
        numsStr = this.numClear.replace(/[^0-9]/g,'');
        return this.numClear = parseInt(numsStr);
    };
    
    this.mostrarUS = function () {
        if( (this.numUS.indexOf('.') >= 0 ) && (this.numUS.indexOf(',') >= 0 ) ){
            this.numUS = this.numUS.replace('.', '');
            this.numUS = this.numUS.replace('.', '');
            this.numUS = this.numUS.replace('.', '');
            this.numUS = this.numUS.replace(',', '.');
            return this.numUS = parseFloat(this.numUS);
        }else{
            this.numUS = this.numUS.replace(',', '.');
            return this.numUS = parseFloat(this.numUS);
        }
        
    };
    
    this.somarNumberCalc = function (){ 
        this.nValor = document.getElementById(this.idOne).value;
        
        if( (this.nValor.indexOf('.') >= 0 ) && (this.nValor.indexOf(',') >= 0 ) ){
            this.nValor = this.nValor.replace('.', '');
            this.nValor = this.nValor.replace('.', '');
            this.nValor = this.nValor.replace('.', '');
            this.nValor = this.nValor.replace(',', '.');
            this.nValor = parseFloat(this.nValor);
        }else{
            this.nValor = this.nValor.replace(',', '.');
            this.nValor = parseFloat(this.nValor);
        }
        
        this.nPorce = parseFloat(document.getElementById(this.idTwo).value);
        
        if(!this.nPorce){
            this.calcTotal = this.nValor;
        }else{
            this.calcTotal =  parseFloat((this.nValor - (this.nValor * this.nPorce / 100)));
        }
        
    };
    
    this.ajaxData = function () {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: this.url,
            //data: 'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&qtdLine='+qtdLine,
            async: true,
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                $('#tableData').html(data);
                $('#loading').fadeOut();
                if (document.getElementById("tableList")) {
                    $('#filtros').show();
                } else {
                    $('#filtros').hide();
                }
            }
        });
    };
    
    this.ajaxFilter = function (page_num) {
                page_num = page_num ? page_num : 0;
                alert(page_num);
                var keywords = $('#keywords').val();
                var qtdLine = $('#qtdLine').val();
                var sortBy = $('#sortBy').val();

                //var keywords = $('#keywords').val();
                //var sortBy = $('#sortBy').val();
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: this.url,
                    data: 'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&qtdLine='+qtdLine,
                    async: true,
                    beforeSend: function (){
                        $('#loading').show();
                    },
                    success: function ( data ){
                        $('#tableData').html( data );
                        $('#loading').fadeOut();
                    }
                });
    };
    
    this.ajaxEditRegister = function (){
        $.ajax({
            type: 'POST',
            dataType:'JSON',
            url: '<?=HOME_URI;?>/finances-pay/ajax-process',
            data: 'action_type=data&id='+id,
            success:function(data){
                //$('#pay_id').val(data.pay_id);
                //$('#pay_venc').val(data.pay_venc);
                //$('#pay_date_pay').val(data.pay_date_pay);
                //$('#pay_desc').val(data.pay_desc);
                //$('#pay_cat').val(data.pay_cat);
                //$('#pay_val').val(data.pay_val);
                //$('#editForm').slideDown();
                return data;
            }
        });
    };
}




//    // Exemplo de uso
//
//    var objFinanca = new Financeiro();
//
//    
//    // ------------------
//    
//    objFinanca.setAjax('btn-dell');
//    
//    objFinanca.getAjax();
//    
//    objFinanca.mostraAjax();
    
    //teste = objFinanca.getUS();
    
    //alert( teste * 3);
    
    //objFinanca.setCalculo('numero_um', 'numero_dois');
    
    //objFinanca.calcNumber();
    
    //teste = objFinanca.getUS();
    



////em float
//formatNumber(1234.53);
////em string real
//formatNumber('1.234,53');
////em string real sem ponto
//formatNumber('1234,53');
////em string americano
//formatNumber('1,234.53');
//
////retornará 1234.53
//function formatNumber(value) {
//    value = convertToFloatNumber(value);
//    return value.formatMoney(2, '.', '');
//}
////retornará 1.234,53
//function formatNumber(value) {
//    value = convertToFloatNumber(value);
//    return value.formatMoney(2, ',', '.');
//}
////retornará 1,234.53
//function formatNumber(value) {
//    value = convertToFloatNumber(value);
//    return value.formatMoney(2, '.', ',');
//}
//
// //transforma a entrada em número float
// var convertToFloatNumber = function(value) {
//     value = value.toString();
//      if (value.indexOf('.') !== -1 && value.indexOf(',') !== -1) {
//          if (value.indexOf('.') <  value.indexOf(',')) {
//             //inglês
//             return parseFloat(value.replace(/,/gi,''));
//          } else {
//            //português
//             return parseFloat(value.replace(/./gi,'').replace(/,/gi,'.'));
//          }      
//      } else {
//         return parseFloat(value);
//      }
//   }
//
////prototype para formatar a saída  
//Number.prototype.formatMoney = function (c, d, t) {
//    var n = this,
//        c = isNaN(c = Math.abs(c)) ? 2 : c,
//        d = d == undefined ? "." : d,
//        t = t == undefined ? "," : t,
//        s = n < 0 ? "-" : "",
//        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
//        j = (j = i.length) > 3 ? j % 3 : 0;
//    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
//};

    