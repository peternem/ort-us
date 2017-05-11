<?php 
$iterator='';
$skus   = $extra['skus'];
$xml ='<?xml version="1.0" encoding="utf-8"?>
            <?qbxml version="10.0"?>
            <QBXML>
                <QBXMLMsgsRq onError="stopOnError">
                    <ItemSitesQueryRq requestID="'.$requestID.'"  '.$iterator.'>
                        <ItemSiteFilter>';
                        if(sizeof($skus) > 0 ){
                            $xml .='<ItemFilter>';
                                foreach( $skus as $sku => $product  ){
                                    if($sku !=''){
                                        $xml.='<FullName><![CDATA[' . $sku . ']]></FullName>';
                                    }              
                                }
                             $xml .='</ItemFilter>';
                        }
                        $xml.='
                            <SiteFilter>
                                <FullName>Auburn</FullName>
                            </SiteFilter>
                        </ItemSiteFilter>
                        <ActiveStatus>All</ActiveStatus>
                    </ItemSitesQueryRq>
                </QBXMLMsgsRq>
            </QBXML>';
return $xml;