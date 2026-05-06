using System;
using System.IO;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;

namespace GymApi.Services
{
    public interface IFileStorageService
    {
        Task<string> SaveFileAsync(IFormFile file, string folder);
        Task DeleteFileAsync(string fileUrl);
    }

    public class LocalStorageService : IFileStorageService
    {
        private readonly string _webRootPath;

        public LocalStorageService(string webRootPath)
        {
            _webRootPath = webRootPath;
        }

        public async Task<string> SaveFileAsync(IFormFile file, string folder)
        {
            if (file == null || file.Length == 0)
                throw new ArgumentException("File is empty");

            // Sanitize and validate
            var allowedExtensions = new[] { ".jpg", ".jpeg", ".png", ".pdf", ".mp4", ".mov" };
            var extension = Path.GetExtension(file.FileName).ToLowerInvariant();
            if (Array.IndexOf(allowedExtensions, extension) < 0)
                throw new ArgumentException("Invalid file type");

            if (file.Length > 10 * 1024 * 1024) // 10MB limit
                throw new ArgumentException("File size exceeds 10MB limit");

            var fileName = $"{Guid.NewGuid()}{extension}";
            var uploadPath = Path.Combine(_webRootPath, "uploads", folder);

            if (!Directory.Exists(uploadPath))
                Directory.CreateDirectory(uploadPath);

            var filePath = Path.Combine(uploadPath, fileName);

            using (var stream = new FileStream(filePath, FileMode.Create))
            {
                await file.CopyToAsync(stream);
            }

            return $"/uploads/{folder}/{fileName}";
        }

        public Task DeleteFileAsync(string fileUrl)
        {
            if (string.IsNullOrEmpty(fileUrl)) return Task.CompletedTask;

            // Convert URL to physical path
            var relativePath = fileUrl.TrimStart('/');
            var physicalPath = Path.Combine(_webRootPath, relativePath.Replace('/', Path.DirectorySeparatorChar));

            if (File.Exists(physicalPath))
            {
                File.Delete(physicalPath);
            }

            return Task.CompletedTask;
        }
    }
}
