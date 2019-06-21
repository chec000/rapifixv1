<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Entities\Gym;

/**
 * Description of Articulo
 *
 * @author sergio
 */
class Articulo {
    public $id;
    public  $nombre;
    public  $tipo;
    public $precio;
    public $descripcion;
    public $cantidad;
    public $subtotal;
    public $duracion_meses;       
            function getDuracion_meses() {
        return $this->duracion_meses;
    }

    function setDuracion_meses($duracion_meses) {
        $this->duracion_meses = $duracion_meses;
    }

        public  $imagen;
    function getImagen() {
        return $this->imagen;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

        function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getSubtotal() {
        return $this->subtotal;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }
    function getTipo_producto() {
        return $this->tipo_producto;
    }

    function setTipo_producto($tipo_producto) {
        $this->tipo_producto = $tipo_producto;
    }

}
