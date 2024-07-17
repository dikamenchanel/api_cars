# API Documentation

## Car API

### Get All Cars

Returns a list of all cars available.

- **URL**

GET /cars
- **Response**
```json
{
  "status": "success",
  "message": "Work My Rest FULL Api",
  "data": []
}

Get Car by ID

Returns details of a car based on its ID.

    URL

GET /cars/{id}

    Parameters

        id (integer): ID of the car to retrieve.
