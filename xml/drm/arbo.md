* Message interprofession
    * SIREN interprofession
    * Déclaration récapitulative
        * ID déclarant
          * numéro accise
          * numéro CVI
        * Période
          * mois
          * année
        * Déclaration-neant (Booléen)
        * **Droits suspendus**
            * Produit
                * Code INAO
                * libellé fiscal (string fixe *VDN_VDL_AOP_SUP_18* *VDN_VDL_AOP_INF_18* ?)
                * libellé personnalisé (string)
                * Balance stocks
                    * Stock début période
                    * Entrées période
                        * Volume produit
                        * Achats Réintégrations
                        * Mouvements temporaires
                            * Embouteillage
                            * Relogement
                            * Travail à façon
                            * Disitillation à façon Entrées
                        * Mouvements internes
                            * Replis déclassement transfert changement d'appellation
                            * Manipulations
                            * Intégration VCI Agree
                        * Replacement suspension
                          * mois 
                          * année
                          * volume
                        * Autres entrées
                    * Sorties période
                        * Ventes France CRD Suspendus
                            * Année précédente (Volume pour l'année précédente, Cas unique des DRA)
                            * Année courante (volume)
                        * Ventes France CRD Acquittés
                        * Sorties sans paiement de droits
                            * Sorties définitives
                            * Consommation familiale Dégustation
                            * Mouvements temporaires
                                * Embouteillage
                                * Relogement
                                * Travail à façon
                                * Distillation à façon
                            * Mouvements internes
                                * Replis Déclassements Transfert Changement appellation
                                * Fabrication autre produit
                                * Revendication VCI
                                * Autres mouvements internes
                            * Autres sorties
                    * Stock fin de période
                * tav (2 digits)
                * premix (boolean)
                * observation (string)
            * Stock épuisé (Boolean)
        * **Droit acquittés**
            * Produit
                * Code INAO
                * Libellé fiscal (string fixe *VDN_VDL_AOP_SUP_18* *VDN_VDL_AOP_INF_18* ?)
                * Libellé personnalisé (string)
                * tav (2 digits)
                * premix
                * Balance stocks
                    * Stock début période
                    * Entrées période
                        * Achats
                        * Autres entrées
                    * Sorties période
                        * Ventes
                        * Replacement suspension
                        * Autres sorties
                    * Stock fin période
                * observations
            * Stock épuisé (Boolean)
        * **Compte CRD**
            * Catégorie fiscale capsules
            * Type capsule
            * Centilisation
                * Stock début période
                * Entrées capsules
                    * Achats
                    * Retours
                    * Excédents
                * Sorties capsules
                    * Utilisations
                    * Destructions
                    * Manquants
                * Stock fin période
        * **Document accompagnement** (x3)
          * numero empreintes
             * début
             * Fin
          * DAA/DCA
             * début
             * Fin
          * DSA/DSAC
             * début
             * Fin
        * **Relevé non apurement**
          * Numéro DAA/DAC/DAE
          * Date expédition
          * Numéro ascise destinataire
        * **Statistiques**
          * Quantité Jus
          * Quantité Mout MCR
          * Quantité Vin vinaigre
