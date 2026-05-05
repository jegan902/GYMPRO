using Microsoft.EntityFrameworkCore;
using GymApi.Data;
using Microsoft.AspNetCore.Authentication.JwtBearer;
using Microsoft.IdentityModel.Tokens;
using System.Text;
using Microsoft.EntityFrameworkCore.Infrastructure;
using Microsoft.EntityFrameworkCore.Storage;
using GymApi.Middlewares;
using GymApi.Authorization;
using Microsoft.AspNetCore.Authorization;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddControllers();
builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();
builder.Services.AddScoped<GymApi.Services.IEmailService, GymApi.Services.EmailService>();

// Configure Phase 3 Services (Booking & Notification)
builder.Services.AddScoped<GymApi.Services.INotificationService, GymApi.Services.NotificationService>();
builder.Services.AddScoped<GymApi.Services.IClassBookingService, GymApi.Services.ClassBookingService>();

// Configure Phase 4 Services (Smart Health, AI Pipeline, DLQ)
builder.Services.AddScoped<GymApi.Services.IHealthMetricService, GymApi.Services.HealthMetricService>();
builder.Services.AddScoped<GymApi.Services.IMessageBus, GymApi.Services.MockMessageBus>();
builder.Services.AddHostedService<GymApi.Services.DataRetentionJob>();

// Configure Advanced RBAC (Permission-based)
builder.Services.AddSingleton<IAuthorizationPolicyProvider, PermissionPolicyProvider>();
builder.Services.AddScoped<IAuthorizationHandler, PermissionAuthorizationHandler>();

// Configure Billing Engine Background Jobs
builder.Services.AddHostedService<GymApi.Services.SubscriptionStatusJob>();

// Configure SQL Server
var connectionString = builder.Configuration.GetConnectionString("DefaultConnection");
builder.Services.AddDbContext<GymDbContext>(options =>
    options.UseSqlServer(connectionString));

// Configure CORS
builder.Services.AddCors(options =>
{
    options.AddPolicy("AllowAll",
        builder => builder.AllowAnyOrigin()
                          .AllowAnyMethod()
                          .AllowAnyHeader());
});

// Configure JWT (Optional: add secret key in appsettings)
var key = Encoding.ASCII.GetBytes("YourSuperSecretKeyGoesHereForDevelopment");
builder.Services.AddAuthentication(x =>
{
    x.DefaultAuthenticateScheme = JwtBearerDefaults.AuthenticationScheme;
    x.DefaultChallengeScheme = JwtBearerDefaults.AuthenticationScheme;
})
.AddJwtBearer(x =>
{
    x.RequireHttpsMetadata = false;
    x.SaveToken = true;
    x.TokenValidationParameters = new TokenValidationParameters
    {
        ValidateIssuerSigningKey = true,
        IssuerSigningKey = new SymmetricSecurityKey(key),
        ValidateIssuer = false,
        ValidateAudience = false
    };
});

var app = builder.Build();

using (var scope = app.Services.CreateScope())
{
    var dbContext = scope.ServiceProvider.GetRequiredService<GymDbContext>();
    var databaseCreator = dbContext.GetService<IRelationalDatabaseCreator>();
    
    try {
        if (!databaseCreator.Exists()) databaseCreator.Create();
        if (!databaseCreator.HasTables()) databaseCreator.CreateTables();

        // Tự động Seed dữ liệu gốc (Roles, Permissions, Admin)
        DataSeeder.SeedData(dbContext);
    } catch (Exception ex) {
        Console.WriteLine("Database initialization error: " + ex.Message);
    }
}



// Configure the HTTP request pipeline.
if (app.Environment.IsDevelopment())
{
    app.UseSwagger();
    app.UseSwaggerUI();
}

app.UseCors("AllowAll");

// Bổ sung Middlewares bảo mật và theo dõi
app.UseMiddleware<CorrelationIdMiddleware>();
// app.UseMiddleware<ApiKeyAuthMiddleware>(); // Tạm đóng lại trên Development để test Swagger dễ dàng hơn

app.UseHttpsRedirection();

app.UseAuthentication();
app.UseAuthorization();

app.MapControllers();

app.Run();
