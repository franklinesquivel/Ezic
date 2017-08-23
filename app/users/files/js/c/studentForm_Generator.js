class Element {
    constructor(type) {
        this.element = document.createElement(type);
    }

    setClass(c){
        this.element.setAttribute('class', c);
    }

    setId(c){
        this.element.setAttribute('id', c);
    }

    setAttr(attr, value){
        this.element.setAttribute(attr, value);
    }

    add_el(element){
        this.element.append(element);
    }

    content(content){
        this.element.innerHTML = content;
    }

    clearContent(){
        this.element.innerHTML = "";
    }
}

function createForm(i){
    //      NOMBRES
    //----------------------------------------
    var input_name = new Element('div');
    input_name.setClass('input-field col l4 m4 s10 offset-s1');

    var txtName = new Element('input');
    txtName.setAttr('type', 'text');
    txtName.setAttr('name', 'txtName');
    txtName.setId('txtName_' + i);

    var txtName_label = new Element('label');
    txtName_label.setAttr('for', 'txtName_' + i);
    txtName_label.content('Nombres');

    input_name.add_el(txtName.element);
    input_name.add_el(txtName_label.element);

    //      APELLIDOS
    //----------------------------------------
    var input_last = new Element('div');
    input_last.setClass('input-field col l4 m4 s10 offset-s1');

    var txtLast = new Element('input');
    txtLast.setAttr('type', 'text');
    txtLast.setAttr('name', 'txtLast');
    txtLast.setAttr('last', 'txtLast_' + i);
    txtLast.setId('txtLast_' + i);

    var txtLast_label = new Element('label');
    txtLast_label.setAttr('for', 'txtLast_' + i);
    txtLast_label.content('Apellidos');

    input_last.add_el(txtLast.element);
    input_last.add_el(txtLast_label.element);

    //      EMAIL
    //------------------------------------------
    var input_email = new Element('div');
    input_email.setClass('input-field col l3 m3 s10 offset-s1');

    var txtEmail = new Element('input');
    txtEmail.setAttr('type', 'text');
    txtEmail.setAttr('name', 'txtEmail');
    txtEmail.setAttr('email', 'txtEmail_' + i);
    txtEmail.setId('txtEmail_' + i);

    var txtEmail_label = new Element('label');
    txtEmail_label.setAttr('for', 'txtEmail_' + i);
    txtEmail_label.content('Correo Electrónico');

    input_email.add_el(txtEmail.element);
    input_email.add_el(txtEmail_label.element);

    //      RESIDENCE
    //------------------------------------------
    var input_res = new Element('div');
    input_res.setClass('input-field col l4 m4 s10 offset-s1');

    var txtRes = new Element('input');
    txtRes.setAttr('type', 'text');
    txtRes.setAttr('name', 'txtRes');
    txtRes.setAttr('res', 'txtRes_' + i);
    txtRes.setId('txtRes_' + i);

    var txtRes_label = new Element('label');
    txtRes_label.setAttr('for', 'txtRes_' + i);
    txtRes_label.content('Residencia');

    input_res.add_el(txtRes.element);
    input_res.add_el(txtRes_label.element);

    //      GENDER
    //------------------------------------------
    var input_sex = new Element('div');
    input_sex.setClass('input-field col l3 m3 s10 offset-s1');

    var sltSex = new Element('select');
    sltSex.setAttr("name", "cmbSex");
    sltSex.setId("cmbSex_" + i);
    sltSex.content("<option disabled selected>Selecciona una opción</option><option value='F'>Femenino</option><option value='M'>Masculino</option>")

    var lblSex = new Element('label');
    lblSex.content('Sexo');

    input_sex.add_el(sltSex.element);
    input_sex.add_el(lblSex.element);

    //      BIRTHDATE
    //------------------------------------------
    var input_date = new Element('div');
    input_date.setClass('input-field col l4 m4 s10 offset-s1');

    var txtDate = new Element('input');
    txtDate.setClass('datepicker');
    txtDate.setAttr('name', 'txtDate');
    txtDate.setAttr('type', 'date');
    txtDate.setAttr('date', 'txtDate_' + i);
    txtDate.setId('txtDate_' + i);

    var txtDate_label = new Element('label');
    txtDate_label.setAttr('for', 'txtDate_' + i);
    txtDate_label.content('Fecha de nacimiento');

    input_date.add_el(txtDate.element);
    input_date.add_el(txtDate_label.element);

    //      FORM
    //------------------------------------------

    var form = new Element('form');
    form.setClass('frmRegister_' + i);
    form.setAttr('autocomplete', 'off');

    var row = new Element('div');
    row.setClass('row');
    row.add_el(input_name.element);
    row.add_el(input_last.element);
    row.add_el(input_email.element);
    form.add_el(row.element);

    var row = new Element('div');
    row.setClass('row');
    row.add_el(input_res.element);
    row.add_el(input_date.element);
    row.add_el(input_sex.element);

    var section = new Element('div');
    section.setClass('form_cont');
    section.element.style.display = "none";
    section.content("<h5 class='center'>Registro " + (parseInt(i) + 1) + "</h5>");
    
    form.add_el(row.element);

    section.add_el(form.element);

    return section.element;
}

