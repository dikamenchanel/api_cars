# API Documentation

## Car API

### Start Page

Returns a empty array, start page.

- **URL**
    - GET
    - ```url / ```

- **Response**
```json
{
  "status": "success",
  "message": "Work My Rest FULL Api",
  "data": []
}
```

### Get All Cars

#### Returns a list of all cars available.

- **URL**
    - GET
    - ```url /cars ```

- **Parameters**
    - not parameter
  
- **Response**
```json
"status":"success",
"message":"",
"data":[
        {
            "id":1,
            "url":"toyota",
            "brand":"Toyota",
            "model":"Camry",
            "year":2015
        },
        {
            "id":2,
            "url":"honda",
            "brand":"Honda",
            "model":"Accord",
            "year":2018
        },
        {
            "id":3,
            "url":"ford",
            "brand":"Ford",
            "model":"F-150",
            "year":2016
        }
....
```

### Get Car by ID

#### Returns details of a car based on its ID.

- **URL**
    - GET
    - ```url /cars/{id} ```

- **Parameters**
    - ``` id ``` (integer): ID of the car to retrieve.
- **Response**



- **URL**
  GET  /cars

- **Parameters**

- **Response**


- **URL**
  GET  /cars

- **Parameters**

- **Response**
  
