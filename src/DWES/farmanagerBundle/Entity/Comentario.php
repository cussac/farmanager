<?php

namespace DWES\farmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comentario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DWES\farmanagerBundle\Entity\ComentarioRepository")
 */
class Comentario
{
    public function __construct()
    {
        $this->setFecha(new\DateTime(date('y-n-d H:i:s')));
    }

    /**
     * @ORM\ManyToOne(targetEntity="Entrada", inversedBy = "entrada")
     *
     */
    private $entrada;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy = "usuario")
     *
     */
    private $usuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=50)
     * @Assert\NotBlank(
     * message = "Este campo no puede quedarse vacío"
     * )
     * @Assert\Length(
     *      min = "1",
     *      max = "50",
     *      minMessage = "El título por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El título no puede tener más de {{ limit }} caracteres de largo"
     * )
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="string", length=140)
     * @Assert\NotBlank(
     * message = "Este campo no puede quedarse vacío"
     * )
     * @Assert\Length(
     *      min = "1",
     *      max = "140",
     *      minMessage = "Tu comentario por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "Tu comentario no puede tener más de {{ limit }} caracteres de largo"
     * )
     */
    private $contenido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Comentario
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return Comentario
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Comentario
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set entrada
     *
     * @param \DWES\farmanagerBundle\Entity\Entrada $entrada
     * @return Comentario
     */
    public function setEntrada(\DWES\farmanagerBundle\Entity\Entrada $entrada = null)
    {
        $this->entrada = $entrada;

        return $this;
    }

    /**
     * Get entrada
     *
     * @return \DWES\farmanagerBundle\Entity\Entrada 
     */
    public function getEntrada()
    {
        return $this->entrada;
    }

    /**
     * Set usuario
     *
     * @param \DWES\farmanagerBundle\Entity\Usuario $usuario
     * @return Comentario
     */
    public function setUsuario(\DWES\farmanagerBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \DWES\farmanagerBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
