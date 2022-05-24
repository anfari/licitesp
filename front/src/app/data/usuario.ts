/**
 * Clase Usuario
 * 
 */
export class Usuario {
    email: string;
    nombre: string;
    password: string;
    localidad: string;
    lugares_interes: string;
    tipos_interes: string;

    /**
     * @constructor
     * @param email email del usuario
     * @param nombre nombre del usuario
     * @param password contrasenia del usuario
     * @param localidad localidad del usuario
     * @param lugares_interes luagres de ejecucion de licitaciones de interes para el usuario
     * @param tipos_interes tipos de licitaciones de interes para el usuario
     */
    constructor(email:string = "", nombre:string = "", password:string = "", localidad:string = "", lugares_interes:string = "", tipos_interes:string = "") {
        this.email = email;
        this.nombre = nombre;
        this.password = password;
        this.localidad = localidad;
        this.lugares_interes = lugares_interes;
        this.tipos_interes = tipos_interes;        
    }
}