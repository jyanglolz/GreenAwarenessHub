using GreenAwarenessHub.Areas.Identity.Data;
using GreenAwarenessHub.Models;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Identity.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore;
using System.Reflection.Emit;

namespace GreenAwarenessHub.Data;

public class GreenAwarenessHubContext : IdentityDbContext<GreenAwarenessHubUser>
{
    public GreenAwarenessHubContext(DbContextOptions<GreenAwarenessHubContext> options)
        : base(options)
    {
    }

    
    public DbSet<UserRole> User_Roles { get; set; }
    public DbSet<Article> Articles { get; set; }
    public DbSet<Feedback> Feedbacks { get; set; }
    public DbSet<Quiz> Quizzes { get; set; }
    public DbSet<Question> Questions { get; set; }
    public DbSet<Answer> Answers { get; set; }
    public DbSet<UserQuizAttempt> UserQuizAttempts { get; set; }

    protected override void OnModelCreating(ModelBuilder builder)
    {
        base.OnModelCreating(builder);
        // Customize the ASP.NET Identity model and override the defaults if needed.
        // For example, you can rename the ASP.NET Identity table names and more.
        // Add your customizations after calling base.OnModelCreating(builder);

        builder.Entity<GreenAwarenessHubUser>()
               .HasOne(u => u.User_Role) // Adjust according to your actual navigation property name
               .WithMany()
               .HasForeignKey(u => u.RoleID)
               .IsRequired();

        builder.Entity<Feedback>()
            .HasOne(f => f.User)
            .WithMany()
            .HasForeignKey(f => f.Id);

        builder.Entity<Feedback>()
            .HasOne(f => f.Article)
            .WithMany()
            .HasForeignKey(f => f.ArticleID);

        builder.Entity<Answer>()
            .HasOne(a => a.Question)
            .WithMany()
            .HasForeignKey(a => a.QuestionID);

        builder.Entity<UserQuizAttempt>()
            .HasOne(a => a.User)
            .WithMany()
            .HasForeignKey(a => a.Id);

        builder.Entity<UserQuizAttempt>()
            .HasOne(a => a.Quiz)
            .WithMany()
            .HasForeignKey(a => a.QuizID);

    }
}
