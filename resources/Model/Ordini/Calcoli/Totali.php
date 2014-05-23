<?php

/**
 * Description of Totali
 * 
 * @author gullo
 */
class Model_Ordini_Calcoli_Totali 
    extends Model_Ordini_Ordine {

    
/*
 *  UPDATE setProdotti
 *      Set Totale qta for Product
 */
    
    function setProdotti($listProd) 
    {
        parent::setProdotti($listProd);
        // SET qta for ALL USERS
        if(count($this->_arProdOriginal) > 0) 
        {
            foreach ($this->_arProdOriginal AS $value) 
            {
                $this->getProdotto($value->idprodotto)->addQtaReale($value->qta);
            }
        }
    }
    
    
    // TOTALE ORDINE (Senza costo di spedizione)
    function getTotale() 
    {
        $t = 0;
        if(count($this->getProdotti()) > 0) 
        {
            foreach ($this->getProdotti() as $idprodotto => $objProd) 
            {
                if($objProd->isDisponibile())
                    $t += $objProd->getTotale();
            }
        }
        return $t;
    }
    
    // TOTALE INCLUSO SPEDIZIONE
    function getTotaleConSpedizione() 
    {
        return ($this->hasCostoSpedizione()) ? ($this->getTotale() + $this->getCostoSpedizione()) : $this->getTotale();
    }
    
    function getTotaleSenzaIva() 
    {
        $t = 0;
        if(count($this->getProdotti()) > 0) 
        {
            foreach ($this->getProdotti() as $idprodotto => $objProd) 
            {
                if($objProd->isDisponibile())
                    $t += $objProd->getTotaleSenzaIva();
            }
        }
        return $t;
    }
    
    function getTotaleColli() {
        $c = 0;
        if(count($this->getProdotti()) > 0) {
            foreach ($this->getProdotti() as $idprodotto => $objProd) {
                if($objProd->isDisponibile())
                    $c += $objProd->qta_reale;
            }
        }
        return $c;
    }
    
    function isThereSomeProductsOrdered() {
        return (count($this->getTotale()) > 0) ? true : false;
    }
    
    
}