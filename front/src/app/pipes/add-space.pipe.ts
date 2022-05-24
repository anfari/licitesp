import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'addSpace'
})
/**
 * Pipe para el formateo de los tipos y lugares de interes
 */
export class AddSpacePipe implements PipeTransform {
  /**
   * Recoge una serio de palabras separadas por coma y las muestra con un espacio entre las comas
   * @param value string a transformar
   * @returns string tranformado
   */
  transform(value: string): string {
    return value.replace(/,/g, ", ");
  }

}
