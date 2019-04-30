(*): Optional

API Documentation
==================
Propositions:

    Get all propositions:
        propositions/get/
        propositions/
        
    Get proposition by ID: proposition/get/:id
        
    Add proposition: proposition/add (POST)
        Must include all necessary arguments{
            user_id
            title
            description
            solution
            risks (*)
            examples (*)
            budget (*)
            law (*)
            environment (*)
            equality (*)
            reference (*)
            echelon (*)
            theme (Themes can be added using their exact name or ID in the database)
            besoin (Same as themes)
        }
        
    Update proposition: proposition/update/:id (PATCH)
    
    Delete proposition: propositions/delete/:id (DELETE)

Contributions: 

    Get, update and delete work like propositions.
    Add works like proposition except either proposition ID (proposition_id) or contribution ID (contribution_id) must be included
    Get all contributions for a proposition: contributions/getbyprop/:id
    
Themes and Besoins:

    Get, add, update and delete work like propositions (Only data needed for adding/updating a new theme/besoin is title)
    
Support:

    Get works like propositions
    Add/update support: support/set (POST)
        Must include all necessary arguements{
            user_id,
            proposition_id,
            essentielle (*),
            innovante (*),
            realisable (*)
        }
        The three fields should be set to 1 for TRUE or 0 for FALSE.
        Set will add a new support or update an existing support.
        Supports will still persist even if the three last fields are FALSE.
        
