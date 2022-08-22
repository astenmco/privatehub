#!/bin/bash



echo "=== REPERTOIRES SUPPRIMES ===";
echo "";

# On recupere la liste des repertoires dans un fichier json
curl  -s -X GET "$REGISTRY:$PORT/v2/_catalog" > /tmp/repositories.json

# On la met en memoire dans le tableau repos
readarray -t repos < <(jq -c '.repositories[]' /tmp/repositories.json)

#pour chaque valeur du tableau on l'affiche
for repo in "${repos[@]}"; do

    #on affiche la liste des  tags du repertoire actuel dans un fichier json
    curl -s -X GET "$REGISTRY:$PORT/v2/$(echo $repo | sed -e 's/"//g' -)/tags/list" > /tmp/tags.json

    # On la met en memoire dans le tableau repos
    readarray -t tags < <(jq -c '.tags' /tmp/tags.json)

    #pour chaque repo on verifie que l'index table soit null
    for tag in "${tags[@]}"; do 
        if [ "$tag" = "null" ]; 
            # si null alors on supprime le repertoire sans tags
            then 
                rm -r /var/lib/registry/docker/registry/v2/repositories/$(echo $repo | sed -e 's/"//g' -)
                echo "$(echo $repo | sed -e 's/"//g' -) suppprimé !"
        fi
    done

done

