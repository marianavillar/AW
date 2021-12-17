<?php
namespace es\ucm\fdi\aw\contrataciones;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\usuarios\Usuario;

class FormularioFinalizarContratacion extends Form{

    private $idContratacion;

    public function __construct($idContratacion) {
        parent::__construct('formFinalizarContratacion');
        $this->idContratacion = $idContratacion;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $camposFormulario=<<<EOF
        <input type="hidden" name="idContratacion" value="{$this->idContratacion}" />
        <button type="submit" onclick="alert('Has finalizado el servicio.');">Finalizar</button>
        EOF;
        return $camposFormulario;
    }
    
    protected function procesaFormulario($datos){

        $idContratacion = $datos['idContratacion'] ?? null ;

        //obtener el usuario que realizo el servicio asignado a esa contratacion
        $contratacion = Contratacion::buscarContratacionPorId($idContratacion);
        $idUsuarioRealiza = $contratacion->getIdUsuarioServicio();

        //cambiar el estado “finalizado” en la tabla  Contrataciones_Servicio (3 => finalizado)
        $contratacion->setEstado(3);
        //actualizar fecha servicio
        $contratacion->setFechaFin();
        $contratacion->actualiza($contratacion);
        
        //Suma 1 en el campo “saldo_monedero” del usuario que realiza el servicio.
        $usuarioRealiza = Usuario::buscaPorId($idUsuarioRealiza);
        $usuarioRealiza->setSaldoMonederoIncrementa();
        $usuarioRealiza->actualizaSaldo($usuarioRealiza);    

        $result = 'ServiciosFinalizadosVista.php';

        return $result;
    }
}