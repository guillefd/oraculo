<?

     /** Genera elementos del FORM (ARRAY DE ARRAY)
     * @param array $vec Array con form items
     * @param <string> $index Nombre del indice del arreglo.
     * @param <string> $label Label
     * @param <string> $input_n Nombre del <input .. name="" >
     * @param <string> $input_id Nombre del <input .. id="" >
     * @param <string> $input_t Tipo del input <input .. type="" >
     * @param <string> $value Valor del input <input value="" >
     * $params string  $js string con valores para javascript
     * $params string  $mode disabled / readonly
     * $params array   $options para select boxes
     * @return array 
     */
    function gen_form_items_array($vec,$index,$label,$input_n,$input_id,$input_t,$value,$js,$mode,$options)
    {
        if($input_t == 'select'){
            $item = array($label,$input_n,$input_id,$input_t,$value,$options,$js,$mode);
        }else{
                $item = array($label,$input_n,$input_id,$input_t,$value,$js,$mode);
            }
        $vec[$index] = $item;
        return $vec;
    }
    




/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
