using Microsoft.AspNetCore.Http;

namespace GymApi.Middlewares
{
    public class ApiKeyAuthMiddleware
    {
        private readonly RequestDelegate _next;
        private const string ApiKeyHeaderName = "X-API-KEY";
        private readonly string _validApiKey;

        public ApiKeyAuthMiddleware(RequestDelegate next, IConfiguration configuration)
        {
            _next = next;
            // Key cấu hình trong appsettings.json hoặc biến môi trường
            _validApiKey = configuration.GetValue<string>("ServiceAuth:ApiKey") ?? "DevelopmentSuperSecretKey";
        }

        public async Task InvokeAsync(HttpContext context)
        {
            // Bỏ qua Swagger và các endpoint public nếu cần
            if (context.Request.Path.StartsWithSegments("/swagger"))
            {
                await _next(context);
                return;
            }

            if (!context.Request.Headers.TryGetValue(ApiKeyHeaderName, out var extractedApiKey))
            {
                context.Response.StatusCode = StatusCodes.Status401Unauthorized;
                await context.Response.WriteAsync("Service Auth: API Key was not provided.");
                return;
            }

            if (!_validApiKey.Equals(extractedApiKey))
            {
                context.Response.StatusCode = StatusCodes.Status403Forbidden;
                await context.Response.WriteAsync("Service Auth: Unauthorized client.");
                return;
            }

            await _next(context);
        }
    }
}
