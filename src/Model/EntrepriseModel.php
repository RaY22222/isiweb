<?php
/* Ces fonctions sont  utilisées dans le controller liée aux entreprises */



require 'interaction.php';

/* renvoie le information speciquement à l'entreprie au numéro $id */


function info_entreprise2($id)
{

    $sql = "SELECT raison_sociale, nom_contact, nom_resp, rue_entreprise, cp_entreprise, ville_entreprise, tel_entreprise, fax_entreprise, email, 
  site_entreprise, niveau, en_activite, libelle, num_entreprise FROM entreprise JOIN spec_entreprise using(num_entreprise) join specialite using(num_spec) 
  WHERE num_entreprise = $id;";
    $result = executeRequete($sql);
    return $result[0];
}



/* met a jour la spécialité d'une entreprise */
function mettreAjour_specialite($id, $specialite)
{
    $sql = "SELECT num_spec FROM specialite WHERE libelle = :specialite";
    $result = executeRequete($sql, ['specialite' => $specialite]);

    if ($result) {
        $num_spec = $result[0]['num_spec'];

        $updateSql = "UPDATE spec_entreprise 
                      SET num_spec = :num_spec 
                      WHERE num_entreprise = :id";
        $updateResult = executeRequete($updateSql, ['num_spec' => $num_spec, 'id' => $id]);

        return $updateResult ? "Specialty updated successfully!" : "Failed to update specialty.";
    }

    return "Specialty not found!";
}


/* met a jour les informations concernant une entreprise */
function mettreAjour_entreprise($id,
    $raison_sociale, $nom_contact, $nom_resp, $rue_entreprise, $cp_entreprise, 
    $ville_entreprise, $tel_entreprise, $fax_entreprise, $email, 
    $observations, $site, $niveau, $specialite          
){

    
    $cp_entreprise = !empty($cp_entreprise) ? (int)$cp_entreprise : NULL;

    $sql = "UPDATE entreprise 
    SET 
        raison_sociale = :raison_sociale,
        nom_contact = :nom_contact,
        nom_resp = :nom_resp,
        rue_entreprise = :rue_entreprise,
        cp_entreprise = :cp_entreprise,
        ville_entreprise = :ville_entreprise,
        tel_entreprise = :tel_entreprise,
        fax_entreprise = :fax_entreprise,
        email = :email,
        observation = :observation,
        site_entreprise = :site,
        niveau = :niveau
    WHERE num_entreprise = :id";

    // Prepare and execute query with bound parameters
    $params = [
        ':raison_sociale' => $raison_sociale,
        ':nom_contact' => $nom_contact,
        ':nom_resp' => $nom_resp,
        ':rue_entreprise' => $rue_entreprise,
        ':cp_entreprise' => $cp_entreprise, // Now this is either an integer or NULL
        ':ville_entreprise' => $ville_entreprise,
        ':tel_entreprise' => $tel_entreprise,
        ':fax_entreprise' => $fax_entreprise,
        ':email' => $email,
        ':observation' => $observations,
        ':site' => $site,
        ':niveau' => $niveau,
        ':id' => $id
    ];


    mettreAjour_specialite($id, $specialite);
    return executeRequete($sql, $params);
}



function supprimer_entreprise($id)
{
    $sql = "DELETE FROM spec_entreprise WHERE num_entreprise = $id;";
    executeRequete($sql);
    $sql =   "DELETE FROM stage WHERE num_entreprise = $id";
    executeRequete($sql);
    $sql  =  "DELETE FROM entreprise WHERE num_entreprise = $id;";
    $result = executeRequete($sql);
    return $result;
}



function ajouter_entreprise(
    $raison_sociale, $nom_contact, $nom_resp, $rue_entreprise, $cp_entreprise,
    $ville_entreprise, $tel_entreprise, $fax_entreprise, $email, 
    $observations, $site, $niveau
) {
    
    $cp_entreprise = !empty($cp_entreprise) ? (int)$cp_entreprise : NULL;

    $sql = "INSERT INTO entreprise (
        raison_sociale, nom_contact, nom_resp, rue_entreprise, cp_entreprise, 
        ville_entreprise, tel_entreprise, fax_entreprise, email, 
        observation, site_entreprise, niveau
    ) VALUES (
        :raison_sociale, :nom_contact, :nom_resp, :rue_entreprise, :cp_entreprise, 
        :ville_entreprise, :tel_entreprise, :fax_entreprise, :email, 
        :observation, :site, :niveau
    )";

    
    $params = [
        ':raison_sociale' => $raison_sociale,
        ':nom_contact' => $nom_contact,
        ':nom_resp' => $nom_resp,
        ':rue_entreprise' => $rue_entreprise,
        ':cp_entreprise' => $cp_entreprise, 
        ':ville_entreprise' => $ville_entreprise,
        ':tel_entreprise' => $tel_entreprise,
        ':fax_entreprise' => $fax_entreprise,
        ':email' => $email,
        ':observation' => $observations,
        ':site' => $site,
        ':niveau' => $niveau
    ];


    

    return executeRequete($sql, $params);


    


}
