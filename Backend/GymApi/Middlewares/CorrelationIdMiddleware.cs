using System.Diagnostics;
using Microsoft.AspNetCore.Http;
using Microsoft.Extensions.Primitives;

namespace GymApi.Middlewares
{
    public class CorrelationIdMiddleware
    {
        private readonly RequestDelegate _next;
        private const string CorrelationIdHeaderName = "X-Correlation-ID";

        public CorrelationIdMiddleware(RequestDelegate next)
        {
            _next = next;
        }

        public async Task InvokeAsync(HttpContext context)
        {
            var correlationId = GetCorrelationId(context);

            // Bổ sung vào Trace Identifier để logging frameworks (như Serilog) tự động capture
            context.TraceIdentifier = correlationId;

            // Đảm bảo response trả về cũng kèm theo ID này để client (Laravel) tra cứu
            context.Response.OnStarting(() =>
            {
                if (!context.Response.Headers.ContainsKey(CorrelationIdHeaderName))
                {
                    context.Response.Headers.Append(CorrelationIdHeaderName, correlationId);
                }
                return Task.CompletedTask;
            });

            await _next(context);
        }

        private static string GetCorrelationId(HttpContext context)
        {
            if (context.Request.Headers.TryGetValue(CorrelationIdHeaderName, out StringValues correlationId))
            {
                return correlationId.ToString();
            }

            // Nếu request không có (vd: không gọi qua Laravel), tự động sinh mới
            return Guid.NewGuid().ToString("D");
        }
    }
}
