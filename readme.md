# Account.Api.My-EcoIdea.org Documentation

===

[api/register]
## Création d'un utilisateur
> request type : json
> method : post
> fields :
- 'name' required | max:75
- 'key' //clés bêta
- 'email' required | max:191
- 'password' required | min :6
- 'password_confirmation' required |
return :
- success | 'token':'[user_token]', 'user' :'[user_informations]'
- error | 'error :'[error_description]

[api/login]
## Connexion d'un utilisateur
> request type : json
> method : post
> fields :
- 'email' required | max:191
- 'password' required | min :6
return :
- success | 'token':'[user_token]'
- error | 'error :'[error_description]

[api/logout]
## Déconnexion d'un utilisateur
> request type : json
> method : post
> fields :
- 'token' required
return :
- success | 'status':'success'

[api/user]
## Récupération d'informations sur un utilisateur
> request type : json
> method : get
> fields :
- 'token' required
return :
- success | 'user':'[user_information]'

[api/modify]
## Modification des informations du profil utilisateur
> request type : json
> method : put
> fields :
- 'password' required
- 'new_name'
- 'new_email'
- 'new_password'
return :
- sucess | 'user':'[user_information]

[api/delete]
## Suppression de son profil
> request type : json
> method : delete
> fields : 
- 'password' required
return :
- sucess | 'sucess':'delete'

## Error structure
[required] The field is empty but is required by the databse
[invalid] The field is invalid for the database, mayby too long/short, or invalid sytaxe
[used] The field is already used in database but it can by duplicated
[bad] The field don't match with the database value

## Task
> Mute user
> Ban user