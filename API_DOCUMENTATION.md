# API DOCUMENTATION

## Base URL
```
https://yourdomain.com/api
```

## Authentication

Gunakan Sanctum tokens untuk API authentication:

```bash
Authorization: Bearer {token}
```

## Endpoints

### Documents

#### List Documents
```
GET /api/documents
```

**Query Parameters:**
- `page` (int) - Halaman pagination
- `per_page` (int) - Items per page (default: 15)
- `category_id` (int) - Filter by category
- `search` (string) - Search title/description

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Laporan Keuangan 2024",
            "description": "...",
            "category_id": 1,
            "file_size": 1024000,
            "created_at": "2024-01-15T10:30:00Z"
        }
    ],
    "pagination": {...}
}
```

#### Get Document
```
GET /api/documents/{id}
```

#### Upload Document
```
POST /api/documents

Content-Type: multipart/form-data

{
    "title": "Dokumen Baru",
    "description": "Deskripsi dokumen",
    "category_id": 1,
    "file": <binary>
    "visibility": "public|restricted|private"
}
```

#### Download Document
```
GET /api/documents/{id}/download
```

### Categories

#### List Categories
```
GET /api/categories
```

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Laporan Keuangan",
            "slug": "laporan-keuangan",
            "icon": "fa-file-invoice-dollar",
            "status": "active"
        }
    ]
}
```

#### Get Category with Documents
```
GET /api/categories/{id}
```

### Statistics

#### Overview Statistics
```
GET /api/statistics/overview
```

**Response:**
```json
{
    "total_documents": 150,
    "total_users": 25,
    "total_categories": 8,
    "documents_today": 5,
    "documents_this_month": 42,
    "storage_used_bytes": 524288000
}
```

#### Documents by Category
```
GET /api/statistics/documents-by-category
```

#### Documents Trend (30 days)
```
GET /api/statistics/documents-trend
```

**Response:**
```json
{
    "data": [
        {
            "date": "2024-01-01",
            "count": 5
        }
    ]
}
```

## Error Responses

### 401 Unauthorized
```json
{
    "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
    "message": "Unauthorized"
}
```

### 404 Not Found
```json
{
    "message": "Not found"
}
```

### 422 Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": ["The title field is required."]
    }
}
```

## Rate Limiting

API rate limit: 60 requests per minute per user

## Examples

### cURL
```bash
# Get documents
curl -X GET "https://yourdomain.com/api/documents" \
  -H "Authorization: Bearer YOUR_TOKEN"

# Upload document
curl -X POST "https://yourdomain.com/api/documents" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "title=Dokumen Baru" \
  -F "category_id=1" \
  -F "file=@/path/to/file.pdf"
```

### JavaScript/Fetch
```javascript
// Get documents
fetch('https://yourdomain.com/api/documents', {
    headers: {
        'Authorization': 'Bearer YOUR_TOKEN'
    }
})
.then(response => response.json())
.then(data => console.log(data));

// Upload document
const formData = new FormData();
formData.append('title', 'Dokumen Baru');
formData.append('category_id', 1);
formData.append('file', fileInput.files[0]);

fetch('https://yourdomain.com/api/documents', {
    method: 'POST',
    headers: {
        'Authorization': 'Bearer YOUR_TOKEN'
    },
    body: formData
})
.then(response => response.json())
.then(data => console.log(data));
```

### Python
```python
import requests

headers = {'Authorization': 'Bearer YOUR_TOKEN'}

# Get documents
response = requests.get(
    'https://yourdomain.com/api/documents',
    headers=headers
)
print(response.json())

# Upload document
files = {'file': open('document.pdf', 'rb')}
data = {
    'title': 'Dokumen Baru',
    'category_id': 1
}
response = requests.post(
    'https://yourdomain.com/api/documents',
    headers=headers,
    files=files,
    data=data
)
print(response.json())
```
