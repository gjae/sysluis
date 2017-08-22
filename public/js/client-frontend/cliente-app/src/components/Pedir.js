import React, { Component } from 'react';
import logo from '../logo.svg';
import '../App.css';
import Navigation from '../components/navbar.js';
import Card from '../components/Cards.js'
import axios from 'axios';
import Carrito from './Carrito.js'

import {Button, Row, Col, Grid, Glyphicon} from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.css'
import store from '../stores/ReducerCarrito.js'
import $ from 'jquery'

import {reactLocalStorage} from 'reactjs-localstorage';

export default class Pedir extends Component{

	constructor(props){
		super(props)
		this.state = {
			carrito: reactLocalStorage.getObject('carrito'),
			nombres: "",
			apellidos: "",
			cedula: "",
			email: "",
			direccion: "",
			fecha_vencimiento: "",
			numero_tarjeta: ""

		}
		store.subscribe(()=>{
			this.setState({
				carrito: store.getState().carrito,
				pagando: false
			})
		});
	}

	realizarPago = () =>{
		this.setState({
			pagando: false
		})

		let formulario = $("#guardar").serialize()
		if( formulario.indexOf('=&') != -1){
			alert("Aún faltan campos por completar.");
			return false;
		}
		formulario = $("#guardar")
		let productos = reactLocalStorage.getObject('carrito')

		var articulos = [];
		var long = productos.length

		for(var i = 0 ;i<long; i++){
			articulos[i] = productos[i].codigo_hardware 
		}

		formulario.attr('action', 'http://localhost:8000/solicitudes/pagar?articulos='+articulos)
		formulario.submit()

		$.post('http://localhost:8000/solicitudes/pagar?articulos='+articulos, formulario, function(e){
			alert(e.mensaje)
			if(! e.error){
				productos = new Array();
				reactLocalStorage.setObject('carrito', productos)
				window.location.href = e.consultar
			}
		})
	}
 	validarCedula(e){
	    var input = e.target
	    var longitud = 15
	    if( !(/^[0-9\-]+$/.test( input.value )) || input.value.length > longitud){
	        alert("El campo que intenta utilizar solo debe contener carácteres numericos y de tener una longitud máxima de "+longitud+ " CARACTERES")
	        input.value = input.value.substring(0 , (input.value.length - 1) ) 
	     }
 	}

 	soloTexto(e){
 		var input = e.target
        if( ( /\d|\u00C0|\u017F|[`~!@#$%^&*()_°¬|+\-=?;:'",.<>\{\}\[\]\\\/]/.test(input.value) ) ){
            alert("El nombre de la persona no debe contener símbolos especiales ni numéricos.")
            input.value = input.value.substring(0 , (input.value.length - 1) )
        } 	
        if(input.value.length > 50)
        {
        	input.value = input.value.substring(0, (input.value.length - 1))
        }
    }

	render(){
		return(
			<div>
				<Navigation />
				<Grid>
					<Row>
						<Col xs={12} sm={12} lg={10}>
							<form method="post" encType="multipart/form-data" action="#" id="guardar">
								<Carrito />
								<Row>
									<Col xs={12} sm={12} md={4} lg={4}>
										<label>Nombres</label>
										<input type="text" className="form-control" onChange={ e => { this.soloTexto(e) } } onKeyDown={ e => { this.soloTexto(e) } } name="nombres" placeholder="Nombres del cliente" />
									</Col>
									<Col xs={12} sm={12} md={4} lg={4}>
										<label>Apellidos </label>
										<input type="text" className="form-control" onChange={ e => { this.soloTexto(e) } } onKeyDown={ e => { this.soloTexto(e) } } name="apellidos" placeholder="Apellidos del cliente" />
									</Col>
									<Col xs={12} sm={12} md={4} lg={4}>
										<label>Cedula</label>
										<input type="text" className="form-control"  onChange={ (e) => {this.validarCedula(e)}} name="cedula" placeholder="Ingresa tu numero de cedula" />
									</Col>
									<Col xs={12} sm={12} md={12} lg={12}>
										<label>Direccion</label>
										<input type="text" className="form-control" name="direccion" placeholder="Direccion de residencia" />
									</Col>
									<Col xs={12} sm={12} md={12} lg={12}>
										<label>Correo electronico</label>
										<input type="text" className="form-control" name="email" placeholder="Direccion de correo electronico" />
									</Col>

									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Telefono personal</label>
										<input type="text" className="form-control" name="telefono_personal" placeholder="Telefono personal" />
									</Col>
									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Telefono de contacto</label>
										<input type="text" className="form-control" name="telefono_habitacion" placeholder="Telefono de contacto" />
									</Col>
									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Numero de transaccion</label>
										<input type="text" className="form-control" name='numero_transaccion' placeholder="Tarjeta de credito" />
									</Col>
									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Soporte de transaccion</label>
										<input type="file" className="form-control" name="imagen_deposito" />
									</Col>
									<br /><br />
									<Col xs={12} sm={12} md={12} lg={6}>
										<br/><br/>
										<Button onClick={ ()=>{this.realizarPago()} } disabled={this.state.pagando} block bsStyle={"success"} >Pagar</Button>
									</Col>
								</Row>
							</form>
						</Col>
					</Row>
				</Grid>
			</div>
		);
	}
}